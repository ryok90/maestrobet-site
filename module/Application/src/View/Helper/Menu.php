<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper 
{
    /**
     * Menu items array.
     * @var array 
     */
    protected $items = [];
    
    /**
     * Active item's ID.
     * @var string  
     */
    protected $activeItemId = '';
    
    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items=[]) 
    {
        $this->items = $items;
    }
    
    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items) 
    {
        $this->items = $items;
    }
    
    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId) 
    {
        $this->activeItemId = $activeItemId;
    }
    
    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render() 
    {
        if (count($this->items)==0) {
            return ''; // Do nothing if there are no items.
        }
        $result = <<<HTML
        <div class="bg-light">
            <nav class="navbar navbar-expand navbar-light">
                <a class="navbar-brand" href="/">
                    maestro<span class="navbar-bet">bet</span>
                </a>
                <img src="/img/logo-brasao.png" alt="Logo" class="navbar-logo">
                    <ul class="navbar-nav">    
HTML;
        // Render items
        foreach ($this->items as $item) {
            $result .= $this->renderItem($item);
        }
        
        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</nav>';
        return $result;        
    }
    
    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item) 
    {        
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id==$this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';
             
        $result = ''; 
     
        $escapeHtml = new EscapeHtml();
        
        if (isset($item['dropdown'])) {
            
            $dropdownItems = $item['dropdown'];
            
            $result .= '<li class="dropdown ' . ($isActive?'active':'') . '">';
            $result .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
            $result .= $escapeHtml($label) . ' <b class="caret"></b>';
            $result .= '</a>';
           
            $result .= '<ul class="dropdown-menu">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';
                
                $result .= '<li>';
                $result .= '<a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
            $result .= '</li>';
            
        } else {        
            $link = isset($item['link']) ? $item['link'] : '#';
            
            $result .= $isActive?'<li class="nav-item active">':'<li class="nav-item">';
            $result .= '<a href="'.$escapeHtml($link).'" class="nav-link">'.$escapeHtml($label).'</a>';
            $result .= '</li>';
        }
    
        return $result;
    }
}
