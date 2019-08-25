<?php
/**
 * @see       https://github.com/zendframework/zend-text for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-text/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Text\Table\Decorator;

/**
 * Interface for Zend\Text\Table decorators
 */
interface DecoratorInterface
{
    /**
     * Get a single character for the top left corner
     *
     * @return string
     */
    public function getTopLeft();

    /**
     * Get a single character for the top right corner
     *
     * @return string
     */
    public function getTopRight();

    /**
     * Get a single character for the bottom left corner
     *
     * @return string
     */
    public function getBottomLeft();

    /**
     * Get a single character for the bottom right corner
     *
     * @return string
     */
    public function getBottomRight();

    /**
     * Get a single character for a vertical line
     *
     * @return string
     */
    public function getVertical();

    /**
     * Get a single character for a horizontal line
     *
     * @return string
     */
    public function getHorizontal();

    /**
     * Get a single character for a crossing line
     *
     * @return string
     */
    public function getCross();

    /**
     * Get a single character for a vertical divider right
     *
     * @return string
     */
    public function getVerticalRight();

    /**
     * Get a single character for a vertical divider left
     *
     * @return string
     */
    public function getVerticalLeft();

    /**
     * Get a single character for a horizontal divider down
     *
     * @return string
     */
    public function getHorizontalDown();

    /**
     * Get a single character for a horizontal divider up
     *
     * @return string
     */
    public function getHorizontalUp();
}
