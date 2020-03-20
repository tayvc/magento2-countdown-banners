<?php
namespace SFS\CountdownBanners\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /***
     * Create the database tables in the schema necessary for the countdown banners.
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('countdown_banners')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('countdown_banners')
            )
                ->addColumn(
                    'banner_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Banner ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Banner Name'
                )
                ->addColumn(
                    'text',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullable' => false],
                    'Banner Text'
                )
                ->addColumn(
                    'bg_color',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Background Color'
                )
                ->addColumn(
                    'text_color',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Banner Text Color'
                )
                ->addColumn(
                    'icon',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Banner Text Icon'
                )
                ->addColumn(
                    'icon_color',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Icon Color'
                )
                ->addColumn(
                    'display_start',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Banner Display Start Date'
                )
                ->addColumn(
                    'display_end',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Banner Display End Date'
                )
                ->addColumn(
                    'link_enabled',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => false],
                    'Banner Link Enabled'
                )
                ->addColumn(
                    'link_url',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Banner Link to Url'
                )
                ->addColumn(
                    'is_active',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => true],
                    'Banner Status'
                )
                ->addColumn(
                    'timer_enabled',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => true],
                    'Banner Timer Enabled'
                )
                ->addColumn(
                    'timer_start',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Timer Start Date'
                )
                ->addColumn(
                    'timer_end',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Timer End Date'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setComment('Countdown Banner Table');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('countdown_banners'),
                $setup->getIdxName(
                    $installer->getTable('countdown_banners'),
                    ['name', 'text'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'text'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
