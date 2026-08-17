<?php

namespace Support\Traits;

/**
 * Мемоизация в пределах одного запроса.
 *
 * Пришла на смену Cache::rememberForever() на дешёвых SQL-запросах:
 * запрос по индексу отрабатывает быстрее, чем чтение и unserialize
 * Eloquent-коллекции из файлового кэша, а инвалидация не нужна вовсе —
 * данные живут только до конца запроса.
 */
trait MemoryCache
{
    public static $cache = [];

    /**
     * Результат по автоматическому ключу «класс::метод + аргументы вызова».
     * Подходит для методов, которые за запрос вызываются несколько раз.
     */
    protected function cache(\Closure $closure)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
        $key = $backtrace['class'] . '::' . $backtrace['function'] . '.' . md5(serialize($backtrace['args']));

        if (!array_key_exists($key, self::$cache)) {
            self::$cache[$key] = call_user_func_array($closure, $backtrace['args']);
        }

        return self::$cache[$key];
    }

    /**
     * Результат по явному ключу — когда автоматический не подходит
     * (значение зависит не от аргументов метода, а от состояния объекта).
     */
    protected function memo(string $key, \Closure $closure)
    {
        if (!array_key_exists($key, self::$cache)) {
            self::$cache[$key] = $closure();
        }

        return self::$cache[$key];
    }

    public static function clear()
    {
        self::$cache = [];
    }
}
