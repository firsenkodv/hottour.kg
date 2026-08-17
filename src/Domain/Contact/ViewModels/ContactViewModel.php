<?php

namespace Domain\Contact\ViewModels;


use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class ContactViewModel
{
    use Makeable;
    use MemoryCache;

    public function listContacts():Collection|array|null
    {
        return $this->cache(function () {

            return Contact::query()
                ->get_contacts()
                ->get();
        });


    }



}
