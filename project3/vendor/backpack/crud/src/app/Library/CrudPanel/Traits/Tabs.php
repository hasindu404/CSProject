<?php

namespace Backpack\CRUD\app\Library\CrudPanel\Traits;

trait Tabs
{
    public function enableTabs()
    {
        $this->setOperationSetting('tabsEnabled', true);
        $this->setOperationSetting('tabsType', config('backpack.crud.operations.'.$this->getCurrentOperation().'.tabsType', 'horizontal'));

        return $this->tabsEnabled();
    }

    public function disableTabs()
    {
        $this->setOperationSetting('tabsEnabled', false);

        return $this->tabsEnabled();
    }

    /**
     * @return bool
     */
    public function tabsEnabled()
    {
        return $this->getOperationSetting('tabsEnabled');
    }

    /**
     * @return bool
     */
    public function tabsDisabled()
    {
        return ! $this->tabsEnabled();
    }

    public function setTabsType($type)
    {
        $this->enableTabs();
        $this->setOperationSetting('tabsType', $type);

        return $this->getOperationSetting('tabsType');
    }

    /**
     * @return string
     */
    public function getTabsType()
    {
        return $this->getOperationSetting('tabsType');
    }

    public function enableVerticalTabs()
    {
        return $this->setTabsType('vertical');
    }

    public function disableVerticalTabs()
    {
        return $this->setTabsType('horizontal');
    }

    public function enableHorizontalTabs()
    {
        return $this->setTabsType('horizontal');
    }

    public function disableHorizontalTabs()
    {
        return $this->setTabsType('vertical');
    }

    /**
     * @param  string  $label
     * @return bool
     */
    public function tabExists($label)
    {
        $tabs = $this->getTabs();

        return in_array($label, $tabs);
    }

    /**
     * @return bool|string
     */
    public function getLastTab()
    {
        $tabs = $this->getTabs();

        if (count($tabs)) {
            return last($tabs);
        }

        return false;
    }

    /**
     * @param $label
     * @return bool
     */
    public function isLastTab($label)
    {
        return $this->getLastTab() == $label;
    }

    /**
     * @deprecated Do not use this method as it will be removed in future versions!
     * Instead, use $this->getElementsWithoutATab($this->getCurrentFields())
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFieldsWithoutATab()
    {
        return $this->getElementsWithoutATab($this->getCurrentFields());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getElementsWithoutATab(array $elements)
    {
        return collect($elements)->filter(function ($value) {
            return ! isset($value['tab']);
        });
    }

    /**
     * @deprecated Do not use this method as it will be removed in future versions!
     * Instead, use $this->getTabItems($tabLabel, 'fields')
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function getTabFields(string $tabLabel)
    {
        return $this->getTabItems($tabLabel, 'fields');
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function getTabItems(string $tabLabel, string $source)
    {
        if (in_array($tabLabel, $this->getUniqueTabNames($source))) {
            $items = $this->getCurrentItems($source);

            return collect($items)->filter(function ($value) use ($tabLabel) {
                return isset($value['tab']) && $value['tab'] == $tabLabel;
            });
        }

        return [];
    }

    public function getTabs(): array
    {
        return $this->getUniqueTabNames('fields');
    }

    /**
     * $source could be `fields` or `columns` for now.
     */
    public function getUniqueTabNames(string $source): array
    {
        $tabs = [];
        $items = $this->getCurrentItems($source);

        collect($items)
            ->filter(function ($value) {
                return isset($value['tab']);
            })
            ->each(function ($value) use (&$tabs) {
                if (! in_array($value['tab'], $tabs)) {
                    $tabs[] = $value['tab'];
                }
            });

        return $tabs;
    }

    private function getCurrentItems(string $source): array
    {
        $items = [];

        switch ($source) {
            case 'fields':
                $items = $this->getCurrentFields();
                break;
            case 'columns':
                $items = $this->columns();
                break;
            default:
                break;
        }

        return $items;
    }
}
