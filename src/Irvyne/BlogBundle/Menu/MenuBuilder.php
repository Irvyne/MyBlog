<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

namespace Irvyne\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;


    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Homepage', array('route' => 'irvyne_blog_homepage'));
        $menu->setChildrenAttribute('class', 'title-area');

        $menu->addChild('<h1>Irvyne\'s Blog</h1>', array(
            'extras' => array(
                'safe_label' => true
            )
        ))
            ->setAttribute('class', 'name');

        $menu->addChild('<a href=""><span>Menu</span></a>')
            ->setAttribute('class', 'toggle-topbar menu-icon');

        $articles = $menu->addChild('Articles', array('route' => 'article'));
        $articles->addChild('List all Articles', array('route' => 'article'));
        $articles->addChild('Create an Article', array('route' => 'article_new'));

        $categories = $menu->addChild('Categories', array('route' => 'category'));
        $categories->addChild('List all Categories', array('route' => 'category'));
        $categories->addChild('Create a Category', array('route' => 'category_new'));

        $tags = $menu->addChild('Tags', array('route' => 'tag'));
        $tags->addChild('List all Tags', array('route' => 'tag'));
        $tags->addChild('Create a Tag', array('route' => 'tag_new'));

        $menu->addChild('Contact');

        return $menu;
    }
} 