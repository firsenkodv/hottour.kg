<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Договор № {{ $contract->contract_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            color: #333;
            min-height: 100vh;
            padding: 40px 16px;
        }

        .contract-wrap {
            max-width: 680px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .contract-header {
            background: #EF533F;
            color: #fff;
            padding: 32px 40px;
        }

        .contract-header__logo {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 20px;
            opacity: .9;
        }

        .contract-header__number {
            font-size: 28px;
            font-weight: 700;
        }

        .contract-header__date {
            font-size: 15px;
            opacity: .75;
            margin-top: 6px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-badge--pending {
            background: rgba(255,255,255,.2);
            color: #fff;
        }

        .status-badge--signed {
            background: #34a853;
            color: #fff;
        }

        .status-badge__dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .contract-body {
            padding: 36px 40px;
        }

        .contract-section {
            margin-bottom: 28px;
        }

        .contract-section__title {
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #282828;
            margin-bottom: 14px;
        }

        .contract-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            gap: 16px;
        }

        .contract-row:last-child { border-bottom: none; }

        .contract-row__label {
            font-size: 15px;
            color: #888;
            flex-shrink: 0;
            min-width: 160px;
        }

        .contract-row__value {
            font-size: 15px;
            font-weight: 500;
            text-align: right;
        }

        .contract-footer {
            padding: 28px 40px 36px;
            border-top: 1px solid #f0f0f0;
        }

        .sign-btn {
            width: 100%;
            padding: 16px;
            background: #EF533F;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .sign-btn:hover { background: #1557b0; }
        .sign-btn:disabled { background: #ccc; cursor: default; }

        .sign-note {
            font-size: 12px;
            color: #aaa;
            text-align: center;
            margin-top: 10px;
        }

        .sign-success {
            display: none;
            background: #e8f5e9;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #2e7d32;
            font-size: 15px;
            font-weight: 500;
        }

        .sign-success.active { display: block; }

        .already-signed {
            background: #e8f5e9;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #2e7d32;
            font-size: 15px;
            font-weight: 500;
        }

        @media (max-width: 600px) {
            body { padding: 0; }
            .contract-wrap { border-radius: 0; }
            .contract-header { padding: 24px 20px; }
            .contract-body { padding: 24px 20px; }
            .contract-footer { padding: 20px 20px 28px; }
            .contract-row { flex-direction: column; gap: 4px; }
            .contract-row__value { text-align: left; }
        }
    </style>
</head>
<body>

<div class="contract-wrap">

    <div class="contract-header">
        <div class="contract-header__logo">ТОО "Hot Tour"</div>
        <div class="contract-header__number">Договор № {{ $contract->contract_number }}</div>
        <div class="contract-header__date">Создан: {{ $contract->created_at->translatedFormat('d F Y') }}</div>

        <div class="status-badge {{ $contract->is_signed ? 'status-badge--signed' : 'status-badge--pending' }}" id="statusBadge">
            <span class="status-badge__dot"></span>
            {{ $contract->is_signed ? 'Подписан' : 'Ожидает подписания' }}
        </div>
    </div>

    <div class="contract-body">

        @if($contract->title)
            <div class="contract-section">
                <div class="contract-section__title">Заметка</div>
                <div class="contract-row">
                    <span class="contract-row__value">{{ $contract->title }}</span>
                </div>
            </div>
        @endif

        <div class="contract-section">
            <div class="contract-section__title">Клиент</div>
            <div class="contract-row">
                <span class="contract-row__label">ФИО</span>
                <span class="contract-row__value">{{ $contract->user?->name ?? '—' }}</span>
            </div>
            @if($contract->passport)
            <div class="contract-row">
                <span class="contract-row__label">Паспорт №</span>
                <span class="contract-row__value">{{ $contract->passport }}</span>
            </div>
            @endif
            @if($contract->passport_issued_at)
            <div class="contract-row">
                <span class="contract-row__label">Выдано</span>
                <span class="contract-row__value">{{ $contract->passport_issued_at }}</span>
            </div>
            @endif
            @if($contract->passport_issued_by)
            <div class="contract-row">
                <span class="contract-row__label">Кем</span>
                <span class="contract-row__value">{{ $contract->passport_issued_by }}</span>
            </div>
            @endif
            @if($contract->inn)
            <div class="contract-row">
                <span class="contract-row__label">ИИН</span>
                <span class="contract-row__value">{{ $contract->inn }}</span>
            </div>
            @endif
            @if($contract->user?->email)
            <div class="contract-row">
                <span class="contract-row__label">Email</span>
                <span class="contract-row__value">{{ $contract->user->email }}</span>
            </div>
            @endif
            @if($contract->user?->phone)
            <div class="contract-row">
                <span class="contract-row__label">Телефон</span>
                <span class="contract-row__value">{{ format_phone($contract->user->phone) }}</span>
            </div>
            @endif
        </div>

        <div class="contract-section">
            <div class="contract-section__title">Тур</div>

            @if($contract->city_departure || $contract->city_arrival)
            <div class="contract-row">
                <span class="contract-row__label">Маршрут</span>
                <span class="contract-row__value">
                    {{ $contract->city_departure ?? '—' }} → {{ $contract->city_arrival ?? '—' }}
                </span>
            </div>
            @endif

            <div class="contract-row">
                <span class="contract-row__label">Дата вылета</span>
                <span class="contract-row__value">
                    {{ $contract->date_departure?->translatedFormat('d F Y') ?? '—' }}
                </span>
            </div>
            <div class="contract-row">
                <span class="contract-row__label">Дата прилёта</span>
                <span class="contract-row__value">
                    {{ $contract->date_arrival?->translatedFormat('d F Y') ?? '—' }}
                </span>
            </div>
            <div class="contract-row">
                <span class="contract-row__label">Количество дней</span>
                <span class="contract-row__value">{{ $contract->days_count }}</span>
            </div>

            @if($contract->hotel_custom || $contract->hotel)
            <div class="contract-row">
                <span class="contract-row__label">Отель</span>
                <span class="contract-row__value">
                    {{ $contract->hotel_custom ?: $contract->hotel?->title ?? '—' }}
                </span>
            </div>
            @endif

            @if($contract->transfer)
            <div class="contract-row">
                <span class="contract-row__label">Трансфер</span>
                <span class="contract-row__value">{{ $contract->transfer === 'yes' ? 'Да' : 'Нет' }}</span>
            </div>
            @endif
            @if($contract->excursion_program)
            <div class="contract-row">
                <span class="contract-row__label">Экскурсионная программа</span>
                <span class="contract-row__value">{{ $contract->excursion_program === 'yes' ? 'Да' : 'Нет' }}</span>
            </div>
            @endif
            @if($contract->russian_speaking_guide)
            <div class="contract-row">
                <span class="contract-row__label">Русскоговорящий гид</span>
                <span class="contract-row__value">{{ $contract->russian_speaking_guide === 'yes' ? 'Да' : 'Нет' }}</span>
            </div>
            @endif
            @if($contract->visa_support)
            <div class="contract-row">
                <span class="contract-row__label">Визовая поддержка</span>
                <span class="contract-row__value">{{ $contract->visa_support === 'yes' ? 'Да' : 'Нет' }}</span>
            </div>
            @endif
            @if($contract->medical_support)
            <div class="contract-row">
                <span class="contract-row__label">Медицинская поддержка</span>
                <span class="contract-row__value">{{ $contract->medical_support === 'yes' ? 'Да' : 'Нет' }}</span>
            </div>
            @endif
            @if($contract->room)
            <div class="contract-row">
                <span class="contract-row__label">Тип номера</span>
                <span class="contract-row__value">{{ $contract->room->title }}</span>
            </div>
            @endif
            @if($contract->food)
            <div class="contract-row">
                <span class="contract-row__label">Питание</span>
                <span class="contract-row__value">{{ $contract->food->title }}</span>
            </div>
            @endif

            <div class="contract-row">
                <span class="contract-row__label">Стоимость тура</span>
                <span class="contract-row__value">{{ number_format($contract->tour_price, 0, '.', ' ') }} ₸</span>
            </div>
        </div>

        @php
            $contractAdults = $contract->people['adults'] ?? [];
            $contractChildren = $contract->people['children'] ?? [];
            $contractAdults = array_filter($contractAdults, fn ($a) => filled($a['fio'] ?? null));
            $contractChildren = array_filter($contractChildren, fn ($c) => filled($c['fio'] ?? null));
        @endphp

        @if(count($contractAdults) || count($contractChildren))
        <div class="contract-section">
            <div class="contract-section__title">Дополнительно</div>

            @foreach($contractAdults as $index => $adult)
            <div class="contract-row">
                <span class="contract-row__label">Взрослый {{ $index + 1 }}</span>
                <span class="contract-row__value">{{ $adult['fio'] }}</span>
            </div>
            @endforeach

            @foreach($contractChildren as $index => $child)
            <div class="contract-row">
                <span class="contract-row__label">Ребёнок {{ $index + 1 }}</span>
                <span class="contract-row__value">{{ $child['fio'] }}{{ filled($child['age'] ?? null) ? ', ' . $child['age'] . ' лет' : '' }}</span>
            </div>
            @endforeach
        </div>
        @endif

    </div>

    @if($contract->framework_url)
    <div class="contract-body" style="padding-top:0;">
        <div class="contract-section">
            <div class="contract-section__title">Документы</div>
            <div class="contract-row">
                <span class="contract-row__label">Рамочный договор</span>
                <span class="contract-row__value">
                    <a href="{{ $contract->framework_url }}" target="_blank" style="color:#EF533F;">Открыть документ</a>
                </span>
            </div>
        </div>
    </div>
    @endif

    <div class="contract-footer">
        @if($contract->is_signed)
            <div class="already-signed">✓ Договор подписан</div>
        @else
            <button class="sign-btn" id="signBtn">Подписать договор</button>
            <p class="sign-note">Нажимая кнопку, вы подтверждаете согласие с условиями договора</p>
            <div class="sign-success" id="signSuccess">✓ Договор успешно подписан</div>
        @endif
    </div>

</div>

<script>
(function () {
    var btn = document.getElementById('signBtn');
    if (!btn) return;

    btn.addEventListener('click', function () {
        btn.disabled = true;
        btn.textContent = 'Подписание...';

        fetch('/contract/{{ $token }}/sign', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.signed) {
                btn.style.display = 'none';
                document.querySelector('.sign-note').style.display = 'none';
                document.getElementById('signSuccess').classList.add('active');

                var badge = document.getElementById('statusBadge');
                badge.className = 'status-badge status-badge--signed';
                badge.innerHTML = '<span class="status-badge__dot"></span> Подписан';
            }
        })
        .catch(function () {
            btn.disabled = false;
            btn.textContent = 'Подписать договор';
            alert('Ошибка. Попробуйте ещё раз.');
        });
    });
}());
</script>

</body>
</html>
