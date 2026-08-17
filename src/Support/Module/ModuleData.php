<?php

namespace Support\Module;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Support\Traits\MemoryCache;

class ModuleData
{
    use MemoryCache;

    public function __construct(
        protected string $position,
        protected Model  $model,
    )
    {

    }

    /**
     * title()/subtitle()/text()/video()/published() дёргают request() по
     * очереди — без мемоизации это давало по одному запросу на каждый
     * геттер модуля.
     */
    public function request(): mixed
    {
        return $this->memo(get_class($this->model) . '.' . $this->position, function () {

            $r =  $this->model::query()->
            where('position', $this->position)->
            where('published', true)->first();

            if (is_null($r)) {
                return'';
            } else {
                  return $r;
            }

        });

    }

    public function video(): string
    {


        if ($module_code = $this->request()) {

            $url = $module_code->module_code;

            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

            if ($match[1]) {
                return $match[1];
            } else {
                return '';
            }
        }

        return '';
    }

    public function title(): string|int
    {
        if ($module_title = $this->request()) {
            return $module_title->module_title;
        }
        return '';
    }

    public function subtitle(): string|int
    {
        if ($module_subtitle = $this->request()) {
            return $module_subtitle->module_subtitle;
        }
        return '';
    }

    public function text(): string|int
    {
        if ($module_text = $this->request()) {
            return $module_text->module_text;
        }
        return '';
        /*       if (is_null(!$this->request())) {
                   return $this->request()->module_text;
               }
               return '';*/
    }
    public function published(): string|int
    {
        if ($module_text = $this->request()) {
            return $module_text->published;
        }
        return '';

    }

}
