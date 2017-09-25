<?php
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

class MytabsPageBlock extends XoopsObject
{
    public $block;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('pageblockid', XOBJ_DTYPE_INT);
        $this->initVar('blockid', XOBJ_DTYPE_INT);
        $this->initVar('pageid', XOBJ_DTYPE_INT);
        $this->initVar('tabid', XOBJ_DTYPE_INT);
        $this->initVar('priority', XOBJ_DTYPE_INT, 0);
        $this->initVar('showalways', XOBJ_DTYPE_TXTBOX, 'yes');
        $this->initVar('placement', XOBJ_DTYPE_TXTBOX, 'center');
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('options', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('fromdate', XOBJ_DTYPE_INT);
        $this->initVar('todate', XOBJ_DTYPE_INT);
        $this->initVar('note', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('pbcachetime', XOBJ_DTYPE_INT, 0);
        $this->initVar('cachebyurl', XOBJ_DTYPE_INT, 0);
        $this->initVar('groups', XOBJ_DTYPE_ARRAY, serialize([XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS]));
    }

    /**
     * Set block of type $blockid as this pageblock's block
     *
     * @param int $blockid
     */
    public function setBlock($blockid = 0)
    {
        require_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';
        if (0 == $blockid) {
            $this->block = new XoopsBlock($this->getVar('blockid'));
            $this->block->assignVar('options', $this->getVar('options', 'n'));
            $this->block->assignVar('title', $this->getVar('title', 'n'));
        } else {
            $this->block = new XoopsBlock($blockid);
            $this->block->assignVar('options', $this->block->getVar('options', 'n'));
            $this->block->assignVar('title', $this->block->getVar('title', 'n'));
        }
    }

    /**
     * Return whether this block is visible now
     *
     * @return bool
     */
    public function isVisible()
    {
        return ('yes' == $this->getVar('showalways')
                || ('time' == $this->getVar('showalways')
                    && $this->getVar('fromdate') <= time()
                    && $this->getVar('todate') >= time()));
    }

    /**
     * Get the form for adding or editing blocks
     *
     * @return MytabsBlockForm
     */
    public function getForm()
    {
        require_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/block.php';
        $form = new MytabsBlockForm('Block', 'blockform', 'block.php');
        $form->createElements($this);

        return $form;
    }

    /**
     * Get pageblock and block objects on array form
     *
     * @param  string $format
     * @return array
     */
    public function toArray($format = 's')
    {
        $ret  = [];
        $vars = $this->getVars();
        foreach (array_keys($vars) as $key) {
            $value     = $this->getVar($key, $format);
            $ret[$key] = $value;
        }

        $vars = $this->block->getVars();
        foreach (array_keys($vars) as $key) {
            $value              = $this->block->getVar($key, $format);
            $ret['block'][$key] = $value;
        }

        // Special values
        $showalways = $this->getVar('showalways');
        if ('no' == $showalways) {
            $ret['unvisible'] = true;
        } elseif ('yes' == $showalways) {
            $ret['visible'] = true;
        } elseif ('time' == $showalways) {
            $check = $this->isVisible();
            if ($check) {
                $ret['timebased'] = true;
            } else {
                $ret['unvisible'] = true;
            }
        }

        return $ret;
    }

    /**
     * Get content for this page block
     *
     * @param      $template
     * @param  int $unique
     * @return array
     * @internal param bool $last
     */
    public function render($template, $unique = 0)
    {
        $block = [
            'blockid'   => $this->getVar('pageblockid'),
            'tabid'     => $this->getVar('tabid'),
            'module'    => $this->block->getVar('dirname'),
            'title'     => $this->getVar('title'),
            'placement' => $this->getVar('placement'),
            'weight'    => $this->getVar('priority')
        ];

        $xoopsLogger = XoopsLogger::getInstance();

        $bcachetime = (int)$this->getVar('pbcachetime');
        if (empty($bcachetime)) {
            $template->caching = 0;
        } else {
            $template->caching        = 2;
            $template->cache_lifetime = $bcachetime;
        }
        $tplName = ($tplName = $this->block->getVar('template')) ? "db:$tplName" : 'db:system_block_dummy.tpl';

        $cacheid = 'blk_' . $this->getVar('pageblockid');

        if ($this->getVar('cachebyurl')) {
            $cacheid .= '_' . md5($_SERVER['REQUEST_URI']);
        }

        if (!$bcachetime || !$template->is_cached($tplName, $cacheid)) {
            $xoopsLogger->addBlock($this->block->getVar('title'));
            if (!($bresult = $this->block->buildBlock())) {
                return false;
            }
            $template->assign('block', $bresult);
            $block['content'] = $template->fetch($tplName, $cacheid);
        } else {
            $xoopsLogger->addBlock($this->block->getVar('name'), true, $bcachetime);
            $block['content'] = $template->fetch($tplName, $cacheid);
        }

        return $block;
    }
}

class MytabsPageBlockHandler extends XoopsPersistableObjectHandler
{
    /**
     * constructor
     * @param XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'mytabs_pageblock', 'MytabsPageBlock', 'pageblockid', 'title');
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

        while ($row = $this->db->fetchArray($result)) {
            $pageblock = $this->create();
            $vars      = array_keys($pageblock->getVars());
            foreach ($row as $name => $value) {
                if (in_array($name, $vars)) {
                    $pageblock->assignVar($name, $value);
                    if ('options' != $name && 'title' != $name) {
                        // Title and options should be set on the block
                        unset($vars[$name]);
                    }
                }
            }

            $pageblock->block = new XoopsBlock($row);

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
     * @return false|MytabsPageBlock
     * @internal param int $moduleid
     * @internal param int $location
     */
    public function newPageBlock($pageid, $tabid, $blockid, $priority = -1)
    {
        if ($priority == -1) {
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

        while (list($id, $name, $title, $modname) = $this->db->fetchRow($result)) {
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

        while (list($id, $name, $title) = $this->db->fetchRow($result)) {
            $ret[$id] = $name . ' --> ' . $title;
        }

        return $ret;
    }
}
