<?php

namespace App\Http;

use Nwidart\Menus\Presenters\Presenter;

class AdminlteMobileCustomPresenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="scrollable__content py-2">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return  '<li>
                    <a href="' . $item->getUrl() . '" ' . $item->getAttributes() . ' class="menu ' . $this->getActiveState($item) . '">
                        <div class="menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="menu__title">' . $item->title . '</div>
                    </a>
                </li>'. PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = 'menu--active')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = ' menu--active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    public function getActiveStateOnChildMenu($item, $state = ' menu__sub-open')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="nav__devider my-6"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="header">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li>
                    <a href="#" class="menu' . $this->getActiveStateOnChild($item) . '" ' . $item->getAttributes() . '>
                        <div class="menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="menu__title">
                            ' . $item->title . ' 
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="treeview-menu ' . $this->getActiveStateOnChildMenu($item) . '">
                        ' . $this->getChildMenuItems($item) . '
                    </ul>
		      	</li>'
        . PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Nwidart\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li>
                    <a href="#" class="menu' . $this->getActiveStateOnChild($item, ' menu--active') . '" ' . $item->getAttributes() . '>
                        <div class="menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="menu__title">
                            ' . $item->title . ' 
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="treeview-menu">
                        ' . $this->getChildMenuItems($item) . '
                    </ul>
		      	</li>'
        . PHP_EOL;
    }
}
