#!/usr/bin/env python3
"""
Формирование базы городов мира с аэропортами.
Источники: GeoNames (cities500 + alternateNames) + OurAirports (airports.csv)
Результат:  storage/app/public/cities/cities_airports.csv
            storage/app/public/cities/cities_airports.sql
"""

import os
import sys
import zipfile
import unicodedata
import urllib.request

import pandas as pd

# ── Пути ─────────────────────────────────────────────────────────────────────
BASE    = os.path.join('storage', 'app', 'public', 'cities')
C_ZIP   = os.path.join(BASE, 'cities500.zip')
C_TXT   = os.path.join(BASE, 'cities500.txt')
A_ZIP   = os.path.join(BASE, 'alternateNames.zip')
A_TXT   = os.path.join(BASE, 'alternateNames.txt')
AP_CSV  = os.path.join(BASE, 'airports.csv')
OUT_CSV = os.path.join(BASE, 'cities_airports.csv')
OUT_SQL = os.path.join(BASE, 'cities_airports.sql')

DOWNLOADS = {
    C_ZIP:  'https://download.geonames.org/export/dump/cities500.zip',
    A_ZIP:  'https://download.geonames.org/export/dump/alternateNames.zip',
    AP_CSV: 'https://davidmegginson.github.io/ourairports-data/airports.csv',
}

# ── Коды стран → русское название ─────────────────────────────────────────────
COUNTRY_RU = {
    'AF': 'Афганистан',       'AL': 'Албания',              'DZ': 'Алжир',
    'AD': 'Андорра',          'AO': 'Ангола',               'AG': 'Антигуа и Барбуда',
    'AR': 'Аргентина',        'AM': 'Армения',              'AU': 'Австралия',
    'AT': 'Австрия',          'AZ': 'Азербайджан',          'BS': 'Багамские острова',
    'BH': 'Бахрейн',          'BD': 'Бангладеш',            'BB': 'Барбадос',
    'BY': 'Беларусь',         'BE': 'Бельгия',              'BZ': 'Белиз',
    'BJ': 'Бенин',            'BT': 'Бутан',                'BO': 'Боливия',
    'BA': 'Босния и Герцеговина', 'BW': 'Ботсвана',         'BR': 'Бразилия',
    'BN': 'Бруней',           'BG': 'Болгария',             'BF': 'Буркина-Фасо',
    'BI': 'Бурунди',          'CV': 'Кабо-Верде',           'KH': 'Камбоджа',
    'CM': 'Камерун',          'CA': 'Канада',               'CF': 'ЦАР',
    'TD': 'Чад',              'CL': 'Чили',                 'CN': 'Китай',
    'CO': 'Колумбия',         'KM': 'Коморы',               'CG': 'Конго',
    'CD': 'ДР Конго',         'CR': 'Коста-Рика',           'CI': "Кот-д'Ивуар",
    'HR': 'Хорватия',         'CU': 'Куба',                 'CY': 'Кипр',
    'CZ': 'Чехия',            'DK': 'Дания',                'DJ': 'Джибути',
    'DM': 'Доминика',         'DO': 'Доминиканская Республика', 'EC': 'Эквадор',
    'EG': 'Египет',           'SV': 'Сальвадор',            'GQ': 'Экваториальная Гвинея',
    'ER': 'Эритрея',          'EE': 'Эстония',              'SZ': 'Эсватини',
    'ET': 'Эфиопия',          'FJ': 'Фиджи',                'FI': 'Финляндия',
    'FR': 'Франция',          'GA': 'Габон',                'GM': 'Гамбия',
    'GE': 'Грузия',           'DE': 'Германия',             'GH': 'Гана',
    'GR': 'Греция',           'GD': 'Гренада',              'GT': 'Гватемала',
    'GN': 'Гвинея',           'GW': 'Гвинея-Бисау',         'GY': 'Гайана',
    'HT': 'Гаити',            'HN': 'Гондурас',             'HU': 'Венгрия',
    'IS': 'Исландия',         'IN': 'Индия',                'ID': 'Индонезия',
    'IR': 'Иран',             'IQ': 'Ирак',                 'IE': 'Ирландия',
    'IL': 'Израиль',          'IT': 'Италия',               'JM': 'Ямайка',
    'JP': 'Япония',           'JO': 'Иордания',             'KZ': 'Казахстан',
    'KE': 'Кения',            'KI': 'Кирибати',             'KP': 'Северная Корея',
    'KR': 'Южная Корея',      'KW': 'Кувейт',               'KG': 'Кыргызстан',
    'LA': 'Лаос',             'LV': 'Латвия',               'LB': 'Ливан',
    'LS': 'Лесото',           'LR': 'Либерия',              'LY': 'Ливия',
    'LI': 'Лихтенштейн',      'LT': 'Литва',                'LU': 'Люксембург',
    'MG': 'Мадагаскар',       'MW': 'Малави',               'MY': 'Малайзия',
    'MV': 'Мальдивы',         'ML': 'Мали',                 'MT': 'Мальта',
    'MH': 'Маршалловы острова', 'MR': 'Мавритания',         'MU': 'Маврикий',
    'MX': 'Мексика',          'FM': 'Микронезия',           'MD': 'Молдова',
    'MC': 'Монако',           'MN': 'Монголия',             'ME': 'Черногория',
    'MA': 'Марокко',          'MZ': 'Мозамбик',             'MM': 'Мьянма',
    'NA': 'Намибия',          'NR': 'Науру',                'NP': 'Непал',
    'NL': 'Нидерланды',       'NZ': 'Новая Зеландия',       'NI': 'Никарагуа',
    'NE': 'Нигер',            'NG': 'Нигерия',              'MK': 'Северная Македония',
    'NO': 'Норвегия',         'OM': 'Оман',                 'PK': 'Пакистан',
    'PW': 'Палау',            'PA': 'Панама',               'PG': 'Папуа — Новая Гвинея',
    'PY': 'Парагвай',         'PE': 'Перу',                 'PH': 'Филиппины',
    'PL': 'Польша',           'PT': 'Португалия',           'QA': 'Катар',
    'RO': 'Румыния',          'RU': 'Россия',               'RW': 'Руанда',
    'KN': 'Сент-Китс и Невис', 'LC': 'Сент-Люсия',         'VC': 'Сент-Винсент и Гренадины',
    'WS': 'Самоа',            'SM': 'Сан-Марино',           'ST': 'Сан-Томе и Принсипи',
    'SA': 'Саудовская Аравия', 'SN': 'Сенегал',             'RS': 'Сербия',
    'SC': 'Сейшелы',          'SL': 'Сьерра-Леоне',         'SG': 'Сингапур',
    'SK': 'Словакия',         'SI': 'Словения',             'SB': 'Соломоновы острова',
    'SO': 'Сомали',           'ZA': 'ЮАР',                  'SS': 'Южный Судан',
    'ES': 'Испания',          'LK': 'Шри-Ланка',            'SD': 'Судан',
    'SR': 'Суринам',          'SE': 'Швеция',               'CH': 'Швейцария',
    'SY': 'Сирия',            'TW': 'Тайвань',              'TJ': 'Таджикистан',
    'TZ': 'Танзания',         'TH': 'Таиланд',              'TL': 'Восточный Тимор',
    'TG': 'Того',             'TO': 'Тонга',                'TT': 'Тринидад и Тобаго',
    'TN': 'Тунис',            'TR': 'Турция',               'TM': 'Туркменистан',
    'TV': 'Тувалу',           'UG': 'Уганда',               'UA': 'Украина',
    'AE': 'ОАЭ',              'GB': 'Великобритания',        'US': 'США',
    'UY': 'Уругвай',          'UZ': 'Узбекистан',           'VU': 'Вануату',
    'VE': 'Венесуэла',        'VN': 'Вьетнам',              'YE': 'Йемен',
    'ZM': 'Замбия',           'ZW': 'Зимбабве',             'PS': 'Палестина',
    'XK': 'Косово',           'HK': 'Гонконг',              'MO': 'Макао',
    'PR': 'Пуэрто-Рико',      'GU': 'Гуам',                 'PF': 'Французская Полинезия',
    'NC': 'Новая Каледония',  'RE': 'Реюньон',              'GP': 'Гваделупа',
    'MQ': 'Мартиника',        'GF': 'Французская Гвиана',   'AW': 'Аруба',
    'CW': 'Кюрасао',          'SX': 'Синт-Мартен',          'EH': 'Западная Сахара',
}

# ── Вспомогательные функции ───────────────────────────────────────────────────

def log(msg):
    print(msg, flush=True)


def norm_str(s):
    """Нормализация строки для нечёткого сопоставления (без диакритики, lower)."""
    if not isinstance(s, str) or not s:
        return ''
    s = unicodedata.normalize('NFD', s.lower().strip())
    s = ''.join(c for c in s if not unicodedata.combining(c))
    return ' '.join(s.split())


def download_file(url, dest):
    log(f'  Скачиваю {os.path.basename(dest)}...')
    os.makedirs(os.path.dirname(dest), exist_ok=True)

    def reporthook(count, block_size, total_size):
        if total_size > 0 and count % 200 == 0:
            pct = min(100, int(count * block_size * 100 / total_size))
            print(f'\r  {pct}%', end='', flush=True)

    urllib.request.urlretrieve(url, dest, reporthook)
    print()


def ensure_files():
    """Скачать отсутствующие файлы."""
    for path, url in DOWNLOADS.items():
        if not os.path.exists(path):
            download_file(url, path)
        else:
            log(f'  {os.path.basename(path)} — уже есть.')


def extract_zip(zip_path, txt_name, dest_path):
    """Извлечь txt_name из zip_path в dest_path, если файла ещё нет."""
    if os.path.exists(dest_path):
        log(f'  {os.path.basename(dest_path)} — уже распакован.')
        return
    log(f'  Распаковываю {os.path.basename(zip_path)}...')
    with zipfile.ZipFile(zip_path, 'r') as z:
        names = z.namelist()
        target = next((n for n in names if os.path.basename(n) == txt_name), None)
        if target is None:
            raise FileNotFoundError(f'{txt_name} не найден в архиве {zip_path}. Содержимое: {names}')
        with z.open(target) as src, open(dest_path, 'wb') as dst:
            while True:
                chunk = src.read(1 << 20)
                if not chunk:
                    break
                dst.write(chunk)
    log(f'  Готово: {os.path.basename(dest_path)}')


# ── Загрузка данных ───────────────────────────────────────────────────────────

CITY_COLS = [
    'geonameid', 'name', 'asciiname', 'alternatenames',
    'latitude', 'longitude', 'feature_class', 'feature_code',
    'country_code', 'cc2', 'admin1', 'admin2', 'admin3', 'admin4',
    'population', 'elevation', 'dem', 'timezone', 'modification_date',
]

ALLOWED_CODES = {'PPL', 'PPLA', 'PPLA2', 'PPLC'}


def load_cities():
    log('1. Загрузка городов (cities500.txt)...')
    df = pd.read_csv(
        C_TXT, sep='\t', header=None, names=CITY_COLS,
        dtype={'geonameid': str, 'country_code': str,
               'feature_class': str, 'feature_code': str},
        low_memory=False, encoding='utf-8',
    )
    before = len(df)
    df = df[
        (df['feature_class'] == 'P') &
        (df['feature_code'].isin(ALLOWED_CODES)) &
        (df['population'] >= 100_000)
    ].copy()
    log(f'   Отфильтровано: {before:,} -> {len(df):,} городов (P + pop>=100k)')
    return df


def load_ru_names(geoname_ids: set) -> dict:
    """Читает alternateNames.txt чанками, возвращает {geonameid: ru_name}."""
    log('2. Загрузка русских названий (alternateNames.txt)...')

    alt_cols = [
        'alternateNameId', 'geonameid', 'isolanguage', 'alternate_name',
        'isPreferredName', 'isShortName', 'isColloquial', 'isHistoric', 'from', 'to',
    ]
    preferred: dict[str, str] = {}
    fallback:  dict[str, str] = {}

    chunk_size = 500_000
    total_chunks = 0
    for chunk in pd.read_csv(
        A_TXT, sep='\t', header=None, names=alt_cols,
        dtype=str, na_filter=False, chunksize=chunk_size,
        encoding='utf-8', low_memory=False,
    ):
        total_chunks += 1
        if total_chunks % 5 == 0:
            log(f'   ...чанк {total_chunks}')

        ru = chunk[
            (chunk['isolanguage'] == 'ru') &
            (chunk['geonameid'].isin(geoname_ids))
        ]
        if ru.empty:
            continue

        pref = ru[ru['isPreferredName'] == '1']
        for _, row in pref.iterrows():
            gid = row['geonameid']
            if gid not in preferred:
                preferred[gid] = row['alternate_name']

        rest = ru[ru['isPreferredName'] != '1']
        for _, row in rest.iterrows():
            gid = row['geonameid']
            if gid not in fallback and gid not in preferred:
                fallback[gid] = row['alternate_name']

    ru_names = {**fallback, **preferred}
    log(f'   Найдено русских названий: {len(ru_names):,}')
    return ru_names


def load_airports():
    log('3. Загрузка аэропортов (airports.csv)...')
    df = pd.read_csv(AP_CSV, dtype=str, na_filter=False, low_memory=False)
    before = len(df)
    df = df[
        df['type'].isin({'large_airport', 'medium_airport'}) &
        (df['iata_code'].str.strip() != '')
    ].copy()
    df['_muni_norm'] = df['municipality'].apply(norm_str)
    log(f'   Аэропортов с IATA (large+medium): {before:,} → {len(df):,}')
    return df


# ── Сопоставление ─────────────────────────────────────────────────────────────

def find_cities_with_airports(cities: pd.DataFrame, airports: pd.DataFrame) -> set:
    log('4. Сопоставление городов с аэропортами...')

    # Строим lookup: (norm_name, country_code) -> set of geonameid
    lookup: dict[tuple, set] = {}
    for _, row in cities.iterrows():
        gid = row['geonameid']
        cc  = row['country_code']
        for field in ('name', 'asciiname'):
            key = (norm_str(str(row[field])), cc)
            lookup.setdefault(key, set()).add(gid)

    matched_ids: set = set()
    unmatched = 0
    for _, ap in airports.iterrows():
        key = (ap['_muni_norm'], ap['iso_country'])
        if key in lookup:
            matched_ids.update(lookup[key])
        else:
            unmatched += 1

    log(f'   Городов с аэропортом: {len(matched_ids):,}  (аэропортов без совпадения: {unmatched:,})')
    return matched_ids


# ── Сохранение ────────────────────────────────────────────────────────────────

def save_csv(df: pd.DataFrame):
    df.to_csv(OUT_CSV, index=False, encoding='utf-8')
    log(f'   CSV → {OUT_CSV}')


def save_sql(df: pd.DataFrame):
    lines = [
        'CREATE TABLE IF NOT EXISTS cities_airports (',
        '    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,',
        '    city_ru      VARCHAR(255) NOT NULL,',
        '    city_en      VARCHAR(255) NOT NULL,',
        '    country_ru   VARCHAR(255) NOT NULL,',
        '    country_code CHAR(2)      NOT NULL,',
        '    population   BIGINT       NOT NULL DEFAULT 0,',
        '    latitude     DECIMAL(9,6) NOT NULL,',
        '    longitude    DECIMAL(9,6) NOT NULL',
        ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
        '',
        'TRUNCATE TABLE cities_airports;',
        '',
    ]

    def esc(v):
        return str(v).replace("'", "''")

    batch = []
    header = (
        "INSERT INTO cities_airports "
        "(city_ru, city_en, country_ru, country_code, population, latitude, longitude) VALUES\n"
    )
    BATCH_SIZE = 500

    def flush(rows):
        lines.append(header + ',\n'.join(rows) + ';')
        lines.append('')

    for _, row in df.iterrows():
        val = (
            f"('{esc(row['city_ru'])}', '{esc(row['city_en'])}', "
            f"'{esc(row['country_ru'])}', '{esc(row['country_code'])}', "
            f"{int(row['population'])}, {row['latitude']}, {row['longitude']})"
        )
        batch.append(val)
        if len(batch) >= BATCH_SIZE:
            flush(batch)
            batch = []

    if batch:
        flush(batch)

    with open(OUT_SQL, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    log(f'   SQL → {OUT_SQL}')


# ── Основной пайплайн ─────────────────────────────────────────────────────────

def main():
    os.makedirs(BASE, exist_ok=True)

    log('=== Шаг 0: Проверка / скачивание файлов ===')
    ensure_files()

    log('\n=== Шаг 1–2: Города и альтернативные названия ===')
    extract_zip(C_ZIP, 'cities500.txt', C_TXT)
    cities = load_cities()

    extract_zip(A_ZIP, 'alternateNames.txt', A_TXT)
    geoname_ids = set(cities['geonameid'].tolist())
    ru_names = load_ru_names(geoname_ids)

    log('\n=== Шаг 3: Аэропорты ===')
    airports = load_airports()

    log('\n=== Шаг 4: Фильтрация по наличию аэропорта ===')
    matched_ids = find_cities_with_airports(cities, airports)
    cities = cities[cities['geonameid'].isin(matched_ids)].copy()

    log('\n=== Шаг 5: Сборка результата ===')
    cities['city_ru']      = cities['geonameid'].map(ru_names).fillna(cities['name'])
    cities['city_en']      = cities['name']
    cities['country_ru']   = cities['country_code'].map(COUNTRY_RU).fillna(cities['country_code'])
    cities['country_code'] = cities['country_code']
    cities['latitude']     = pd.to_numeric(cities['latitude'],  errors='coerce').round(6)
    cities['longitude']    = pd.to_numeric(cities['longitude'], errors='coerce').round(6)
    cities['population']   = pd.to_numeric(cities['population'], errors='coerce').fillna(0).astype(int)

    result = (
        cities[['city_ru', 'city_en', 'country_ru', 'country_code', 'population', 'latitude', 'longitude']]
        .drop_duplicates(subset=['city_en', 'country_code'])
        .sort_values(['country_code', 'population'], ascending=[True, False])
        .reset_index(drop=True)
    )
    result.index += 1
    result.index.name = 'id'

    log(f'   Итоговых записей: {len(result):,}')
    log('\n   Пример (первые 5):')
    log(result.head().to_string())

    log('\n=== Шаг 6: Сохранение ===')
    save_csv(result.reset_index())
    save_sql(result.reset_index())

    log('\nГотово!')


if __name__ == '__main__':
    main()
