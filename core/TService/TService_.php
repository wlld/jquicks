<?php
class TService_ extends TComponent_{
    public function removeFromProject($parent, $section, $order, $page) {
        parent::removeFromProject($parent, $section, $order, $page);
        if($this->project->isComponentExists('TAccountService')) {
            $this->project->getByName('TAccountService')->removeServiceRights($this->id);
        }
    }
}

