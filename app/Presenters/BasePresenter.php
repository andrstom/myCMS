<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {
    
    
    protected function beforeRender()
    {
        // translate MONTHS
        $this->template->addFilter('czMonth', function ($date) {
            
            $en_datetime = strtotime($date->__toString());
            $engMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $czechMonths = ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'];
            $cz_datetime = str_replace($engMonths, $czechMonths, date('F', $en_datetime));

            return ($cz_datetime);
        });
        
        // translate DAYS
        $this->template->addFilter('czDay', function ($date) {
            
            $en_datetime = strtotime($date->__toString());
            $engDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $czechDays = ['Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle'];
            $cz_datetime = str_replace($engDays, $czechDays, date('l', $en_datetime));

            return ($cz_datetime);
        });
    }
}
