<?php

namespace App\Http;

use Nwidart\Menus\Presenters\Presenter;

class AdminlteCustomPresenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul>' . PHP_EOL;
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
                    <a href="' . $item->getUrl() . '" ' . $item->getAttributes() . ' class="side-menu ' . $this->getActiveState($item) . '">
                        <div class="side-menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="side-menu__title">' . $item->title . '</div>
                    </a>
                </li>'. PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = 'side-menu--active')
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
    public function getActiveStateOnChild($item, $state = ' side-menu--active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    public function getActiveStateOnChildMenu($item, $state = ' side-menu__sub-open')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="side-nav__devider my-6"></li>';
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
                    <a href="#" class="side-menu' . $this->getActiveStateOnChild($item) . '" ' . $item->getAttributes() . '>
                        <div class="side-menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="side-menu__title">
                            ' . $item->title . ' 
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
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
                    <a href="#" class="side-menu' . $this->getActiveStateOnChild($item, ' side-menu--active') . '" ' . $item->getAttributes() . '>
                        <div class="side-menu__icon"> ' . $item->getIcon() . ' </div>
                        <div class="side-menu__title">
                            ' . $item->title . ' 
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="treeview-menu">
                        ' . $this->getChildMenuItems($item) . '
                    </ul>
		      	</li>'
        . PHP_EOL;
    }
}
