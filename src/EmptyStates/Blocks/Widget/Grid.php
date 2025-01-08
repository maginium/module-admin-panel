<?php

declare(strict_types=1);

namespace Maginium\AdminGrid\Blocks\Widget;

use Magento\Backend\Block\Widget\Grid as BaseGrid;

/**
 * Backend Grid Widget Block.
 *
 * This class represents a backend grid widget block.
 * It extends the MagentoGrid class.
 */
class Grid extends BaseGrid
{
    /**
     * The template file for the grid widget block.
     *
     * @var string
     */
    protected $_template = 'Maginium_AdminGrid::widget/grid.phtml';
}
