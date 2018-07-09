<?php namespace XoopsModules\Mytabs;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 */
// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");


class PageBlockHandler extends \XoopsPersistableObjectHandler
{
    /**
     * constructor
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'mytabs_pageblock', PageBlock::class, 'pageblockid', 'title');
    }

    /**
     * Get all blocks for a given tabid - or all tabids
     *
     * @param int    $pageid
     * @param int    $tabid 0 = all tabids
     * @param string $placement
     * @param string $remove
     * @param bool   $not_invisible
     * @return array
     * @internal param array $locations optional parameter if you want to override auto-detection of location
     */
    public function getBlocks($pageid = 0, $tabid = 0, $placement = '', $remove = '', $not_invisible = true)
    {
        $blocks = [];
        $sql    = 'SELECT *, pb.options, pb.title FROM ' . $this->db->prefix('mytabs_pageblock') . ' pb LEFT JOIN ' . $this->db->prefix('newblocks') . ' b ON pb.blockid=b.bid WHERE (pb.pageid = ' . $pageid . ')';

        if ($tabid > 0) {
            $sql .= ' AND (pb.tabid = ' . $tabid . ')';
        }

        if ('' != $remove) {
            $sql .= " AND (pb.options NOT LIKE '%|" . $remove . "|%')";
        }

        if ('' != $placement) {
            $sql .= " AND (pb.placement = '" . $placement . "')";
        }

        if ($not_invisible) {
            // Only get blocks that can be visible
            $sql .= " AND (pb.showalways IN ('yes', 'time'))";
        }

        $sql    .= ' ORDER BY PLACEMENT, PRIORITY ASC';
        $result = $this->db->query($sql);

        if (!$result) {
            return [];
        }

        require_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';

        while (false !== ($row = $this->db->fetchArray($result))) {
            $pageblock = $this->create();
            $vars      = array_keys($pageblock->getVars());
            foreach ($row as $name => $value) {
                if (in_array($name, $vars)) {
                    $pageblock->assignVar($name, $value);
                    if ('options' !== $name && 'title' !== $name) {
                        // Title and options should be set on the block
                        unset($vars[$name]);
                    }
                }
            }

            $pageblock->block = new \XoopsBlock($row);

            $blocks[$pageblock->getVar('tabid')][] = $pageblock;
        }

        return $blocks;
    }

    /**
     * Insert a new page block ready to be configured
     *
     * @param     $pageid
     * @param int $tabid
     * @param int $blockid
     * @param int $priority
     * @return false|PageBlock
     * @internal param int $moduleid
     * @internal param int $location
     */
    public function newPageBlock($pageid, $tabid, $blockid, $priority = -1)
    {
        if (-1 == $priority) {
            $priority = $this->getMaxPriority($pageid, $tabid);
        }

        $block = $this->create();
        $block->setVar('pageid', $pageid);
        $block->setVar('tabid', $tabid);
        $block->setVar('blockid', $blockid);
        $block->setVar('priority', $priority);

        if ($this->insert($block)) {
            return $block;
        }

        return false;
    }

    /**
     * Get maximum priority value for a tabid
     *
     * @param     $pageid
     * @param int $tabid
     * @return int
     * @internal param int $moduleid
     * @internal param int $location
     */
    public function getMaxPriority($pageid, $tabid)
    {
        $result = $this->db->query('
            SELECT MAX(priority) FROM ' . $this->db->prefix('mytabs_pageblock') . 'WHERE pageid=' . (int)$pageid . 'AND tabid=' . (int)$tabid);

        if (0 == $this->db->getRowsNum($result)) {
            $priority = 1;
        } else {
            $row      = $this->db->fetchRow($result);
            $priority = $row[0] + 1;
        }

        return $priority;
    }

    /**
     * Get all available blocks
     *
     * @return array
     */
    public function getAllBlocks()
    {
        $ret    = [];
        $result = $this->db->query('SELECT bid, b.name AS name, b.title AS title, m.name AS modname  FROM ' . $this->db->prefix('newblocks') . ' b, ' . $this->db->prefix('modules') . ' m WHERE (b.mid=m.mid) ORDER BY modname, name');

        while (false !== (list($id, $name, $title, $modname) = $this->db->fetchRow($result))) {
            $ret[$id] = $modname . ' --> ' . $title . ' (' . $name . ')';
        }

        return $ret;
    }

    /**
     * Get all custom blocks
     *
     * @return array
     */
    public function getAllCustomBlocks()
    {
        $ret    = [];
        $result = $this->db->query('
            SELECT bid, name, title FROM ' . $this->db->prefix('newblocks') . '  WHERE  mid = 0 ORDER BY name');

        while (false !== (list($id, $name, $title) = $this->db->fetchRow($result))) {
            $ret[$id] = $name . ' --> ' . $title;
        }

        return $ret;
    }
}
