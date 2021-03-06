<?php

/**
 * @package SimplePortal ElkArte
 *
 * @author SimplePortal Team
 * @copyright 2015 SimplePortal Team
 * @license BSD 3-clause
 * @version 1.0.0 Beta 1
 */

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('ELK'))
{
	$_GET['debug'] = 'Blue Dream!';
	require_once(dirname(__FILE__) . '/SSI.php');
}
elseif (!defined('ELK'))
	die('<b>Error:</b> Cannot install - please verify you put this in the same place as ELK\'s index.php.');

global $db_prefix, $db_package_log;

$db = database();
$db_table = db_table();

$sp_tables = array(
	'sp_articles' => array(
		'columns' => array(
			array('name' => 'id_article', 'type' => 'mediumint', 'size' => 8, 'auto' => true),
			array('name' => 'id_category', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'id_member', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'member_name', 'type' => 'varchar', 'size' => 80, 'default' => 0),
			array('name' => 'namespace', 'type' => 'tinytext'),
			array('name' => 'title', 'type' => 'tinytext'),
			array('name' => 'body', 'type' => 'text'),
			array('name' => 'type', 'type' => 'tinytext'),
			array('name' => 'date', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'permissions', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'views', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'comments', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'status', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_article')),
		),
	),
	'sp_blocks' => array(
		'columns' => array(
			array('name' => 'id_block', 'type' => 'int', 'size' => 10, 'auto' => true),
			array('name' => 'label', 'type' => 'tinytext'),
			array('name' => 'type', 'type' => 'text'),
			array('name' => 'col', 'type' => 'tinyint', 'size' => 4, 'default' => 0),
			array('name' => 'row', 'type' => 'tinyint', 'size' => 4, 'default' => 0),
			array('name' => 'permissions', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'state', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
			array('name' => 'force_view', 'type' => 'tinyint', 'size' => 2, 'default' => 0),
			array('name' => 'mobile_view', 'type' => 'tinyint', 'size' => 2, 'default' => 0),
			array('name' => 'display', 'type' => 'text',),
			array('name' => 'display_custom', 'type' => 'text'),
			array('name' => 'style', 'type' => 'text'),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_block')),
			array('type' => 'index', 'columns' => array('state')),
		),
	),
	'sp_categories' => array(
		'columns' => array(
			array('name' => 'id_category', 'type' => 'mediumint', 'size' => 8, 'auto' => true),
			array('name' => 'namespace', 'type' => 'tinytext'),
			array('name' => 'name', 'type' => 'tinytext'),
			array('name' => 'description', 'type' => 'text'),
			array('name' => 'permissions', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'articles', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'status', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_category')),
		),
	),
	'sp_comments' => array(
		'columns' => array(
			array('name' => 'id_comment', 'type' => 'mediumint', 'size' => 8, 'auto' => true),
			array('name' => 'id_article', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'id_member', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'member_name', 'type' => 'varchar', 'size' => 80, 'default' => 0),
			array('name' => 'body', 'type' => 'text'),
			array('name' => 'log_time', 'type' => 'int', 'size' => 10, 'default' => 0),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_comment')),
		),
	),
	'sp_functions' => array(
		'columns' => array(
			array('name' => 'id_function', 'type' => 'tinyint', 'size' => 4, 'auto' => true),
			array('name' => 'function_order', 'type' => 'tinyint', 'size' => 4, 'default' => 0),
			array('name' => 'name', 'type' => 'tinytext'),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_function')),
		),
	),
	'sp_pages' => array(
		'columns' => array(
			array('name' => 'id_page', 'type' => 'int', 'size' => 10, 'auto' => true),
			array('name' => 'namespace', 'type' => 'tinytext'),
			array('name' => 'title', 'type' => 'tinytext'),
			array('name' => 'body', 'type' => 'mediumtext'),
			array('name' => 'type', 'type' => 'tinytext'),
			array('name' => 'permissions', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'views', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'style', 'type' => 'text'),
			array('name' => 'status', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_page')),
		),
	),
	'sp_parameters' => array(
		'columns' => array(
			array('name' => 'id_block', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'variable', 'type' => 'varchar', 'size' => 255, 'default' => ''),
			array('name' => 'value', 'type' => 'text'),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_block', 'variable')),
			array('type' => 'key', 'columns' => array('variable')),
		),
	),
	'sp_profiles' => array(
		'columns' => array(
			array('name' => 'id_profile', 'type' => 'mediumint', 'size' => 8, 'auto' => true),
			array('name' => 'type', 'type' => 'tinyint', 'size' => 4, 'default' => 0),
			array('name' => 'name', 'type' => 'tinytext'),
			array('name' => 'value', 'type' => 'text'),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_profile')),
		),
	),
	'sp_shoutboxes' => array(
		'columns' => array(
			array('name' => 'id_shoutbox', 'type' => 'int', 'size' => 10, 'auto' => true),
			array('name' => 'name', 'type' => 'tinytext'),
			array('name' => 'permissions', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'moderator_groups', 'type' => 'text'),
			array('name' => 'warning', 'type' => 'text'),
			array('name' => 'allowed_bbc', 'type' => 'text'),
			array('name' => 'height', 'type' => 'smallint', 'size' => 5, 'default' => 200),
			array('name' => 'num_show', 'type' => 'smallint', 'size' => 5, 'default' => 20),
			array('name' => 'num_max', 'type' => 'mediumint', 'size' => 8, 'default' => 1000),
			array('name' => 'refresh', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
			array('name' => 'reverse', 'type' => 'tinyint', 'size' => 4, 'default' => 0),
			array('name' => 'caching', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
			array('name' => 'status', 'type' => 'tinyint', 'size' => 4, 'default' => 1),
			array('name' => 'num_shouts', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'last_update', 'type' => 'int', 'size' => 10, 'default' => 0),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_shoutbox')),
		),
	),
	'sp_shouts' => array(
		'columns' => array(
			array('name' => 'id_shout', 'type' => 'mediumint', 'size' => 8, 'auto' => true),
			array('name' => 'id_shoutbox', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'id_member', 'type' => 'mediumint', 'size' => 8, 'default' => 0),
			array('name' => 'member_name', 'type' => 'varchar', 'size' => 80, 'default' => 0),
			array('name' => 'log_time', 'type' => 'int', 'size' => 10, 'default' => 0),
			array('name' => 'body', 'type' => 'text'),
		),
		'indexes' => array(
			array('type' => 'primary', 'columns' => array('id_shout')),
		),
	),
);

foreach ($sp_tables as $sp_table => $data)
	$db_table->db_create_table('{db_prefix}' . $sp_table, $data['columns'], $data['indexes'], array(), 'ignore');

$db->insert('ignore',
	'{db_prefix}sp_functions',
	array('id_function' => 'int', 'function_order' => 'int', 'name' => 'string'),
	array(
		array(1, 1, 'sp_userInfo'),
		array(2, 2, 'sp_latestMember'),
		array(3, 3, 'sp_whosOnline'),
		array(5, 4, 'sp_boardStats'),
		array(7, 5, 'sp_topPoster'),
		array(35, 6, 'sp_topStatsMember'),
		array(23, 7, 'sp_recent'),
		array(9, 8, 'sp_topTopics'),
		array(8, 9, 'sp_topBoards'),
		array(4, 10, 'sp_showPoll'),
		array(12, 11, 'sp_boardNews'),
		array(6, 12, 'sp_quickSearch'),
		array(13, 13, 'sp_news'),
		array(20, 14, 'sp_attachmentImage'),
		array(21, 15, 'sp_attachmentRecent'),
		array(27, 16, 'sp_calendar'),
		array(24, 17, 'sp_calendarInformation'),
		array(25, 18, 'sp_rssFeed'),
		array(28, 19, 'sp_theme_select'),
		array(29, 20, 'sp_staff'),
		array(31, 21, 'sp_articles'),
		array(36, 22, 'sp_shoutbox'),
		array(26, 23, 'sp_gallery'),
		array(10, 24, 'sp_menu'),
		array(19, 98, 'sp_bbc'),
		array(17, 99, 'sp_html'),
		array(18, 100, 'sp_php'),
	),
	array('id_function')
);

$result = $db->query('', '
	SELECT id_block
	FROM {db_prefix}sp_blocks
	LIMIT 1',
	array(
	)
);
list ($has_block) = $db->fetch_row($result);
$db->free_result($result);

if (empty($has_block))
{
	$welcome_text = '<h2 style="text-align: center;">Welcome to SimplePortal!</h2>
<p>SimplePortal is one of several portal mods for Elkarte. Although always developing, SimplePortal is produced with the user in mind first. User feedback is the number one method of growth for SimplePortal, and our users are always finding ways for SimplePortal to grow. SimplePortal stays competative with other portal software by adding numerous user-requested features such as articles, block types and the ability to completely customize the portal page.</p>
<p>All this and SimplePortal has remained Simple! SimplePortal is built for simplicity and ease of use; ensuring the average forum administrator can install SimplePortal, configure a few settings, and show off the brand new portal to the users in minutes. Confusing menus, undesired pre-loaded blocks and settings that cannot be found are all avoided as much as possible. Because when it comes down to it, SimplePortal is YOUR portal, and should reflect your taste as much as possible.</p>';

	$default_blocks = array(
	'user_info' => array('label' => 'User Info', 'type' => 'sp_userInfo', 'col' => 1, 'row' => 1, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'whos_online' => array('label' => 'Who&#039;s Online', 'type' => 'sp_whosOnline', 'col' => 1, 'row' => 2, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'board_stats' => array('label' => 'Board Stats', 'type' => 'sp_boardStats', 'col' => 1, 'row' => 3, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'theme_select' => array('label' => 'Theme Select', 'type' => 'sp_theme_select', 'col' => 1, 'row' => 4, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'search' => array('label' => 'Search', 'type' => 'sp_quickSearch', 'col' => 1, 'row' => 5, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'news' => array('label' => 'News', 'type' => 'sp_news', 'col' => 2, 'row' => 1, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => 'title_default_class~|title_custom_class~|title_custom_style~|body_default_class~windowbg|body_custom_class~|body_custom_style~|no_title~1|no_body~'),
		'welcome' => array('label' => 'Welcome', 'type' => 'sp_html', 'col' => 2, 'row' => 2, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => 'title_default_class~|title_custom_class~|title_custom_style~|body_default_class~windowbg|body_custom_class~|body_custom_style~|no_title~1|no_body~'),
		'board_news' => array('label' => 'Board News', 'type' => 'sp_boardNews', 'col' => 2, 'row' => 3, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'recent_topics' => array('label' => 'Recent Topics', 'type' => 'sp_recent', 'col' => 3, 'row' => 1, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'top_poster' => array('label' => 'Top Poster', 'type' => 'sp_topPoster', 'col' => 4, 'row' => 1, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'recent_posts' => array('label' => 'Recent Posts', 'type' => 'sp_recent', 'col' => 4, 'row' => 2, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'staff' => array('label' => 'Forum Staff', 'type' => 'sp_staff', 'col' => 4, 'row' => 3, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'calendar' => array('label' => 'Calendar', 'type' => 'sp_calendar', 'col' => 4, 'row' => 4, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
		'top_boards' => array('label' => 'Top Boards', 'type' => 'sp_topBoards', 'col' => 4, 'row' => 5, 'permissions' => 3, 'display' => '', 'display_custom' => '', 'style' => ''),
	);

	$db->insert('ignore',
		'{db_prefix}sp_blocks',
		array('label' => 'text', 'type' => 'text', 'col' => 'int', 'row' => 'int', 'permissions' => 'int', 'display' => 'text', 'display_custom' => 'text', 'style' => 'text'),
		$default_blocks,
		array('id_block', 'state')
		);

	$request = $db->query('', '
		SELECT MIN(id_block) AS id, type
		FROM {db_prefix}sp_blocks
		WHERE type IN ({array_string:types})
		GROUP BY type
		LIMIT 4',
		array(
			'types' => array('sp_html', 'sp_boardNews', 'sp_calendar', 'sp_recent'),
		)
	);
	while ($row = $db->fetch_assoc($request))
		$block_ids[$row['type']] = $row['id'];
	$db->free_result($request);

	$default_parameters = array(
		array('id_block' => $block_ids['sp_html'], 'variable' => 'content', 'value' => htmlspecialchars($welcome_text)),
		array('id_block' => $block_ids['sp_boardNews'], 'variable' => 'avatar', 'value' => 1),
		array('id_block' => $block_ids['sp_boardNews'], 'variable' => 'per_page', 'value' => 3),
		array('id_block' => $block_ids['sp_calendar'], 'variable' => 'events', 'value' => 1),
		array('id_block' => $block_ids['sp_calendar'], 'variable' => 'birthdays', 'value' => 1),
		array('id_block' => $block_ids['sp_calendar'], 'variable' => 'holidays', 'value' => 1),
		array('id_block' => $block_ids['sp_recent'], 'variable' => 'type', 'value' => 1),
		array('id_block' => $block_ids['sp_recent'], 'variable' => 'display', 'value' => 1),
	);

	$db->insert('replace',
		'{db_prefix}sp_parameters',
		array('id_block' => 'int', 'variable' => 'text', 'value' => 'text'),
		$default_parameters,
		array('id_block', 'variable')
	);
}

$result = $db->query('', '
	SELECT id_profile
	FROM {db_prefix}sp_profiles
	WHERE type = {int:type}
	LIMIT {int:limit}',
	array(
		'type' => 1,
		'limit' => 1,
	)
);
list ($has_permission_profiles) = $db->fetch_row($result);
$db->free_result($result);

if (empty($has_permission_profiles))
{
	$request = $db->query('', '
		SELECT id_group
		FROM {db_prefix}membergroups
		WHERE min_posts != {int:min_posts}',
		array(
			'min_posts' => -1,
		)
	);
	$post_groups = array();
	while ($row = $db->fetch_assoc($request))
		$post_groups[] = $row['id_group'];
	$db->free_result($request);

	$db->insert('replace',
		'{db_prefix}sp_profiles',
		array('id_profile' => 'int', 'type' => 'int', 'name' => 'text', 'value' => 'text'),
		array(
			array(1, 1, '$_guests', '-1|'),
			array(2, 1, '$_members', implode(',', $post_groups) . ',0|'),
			array(3, 1, '$_everyone', implode(',', $post_groups) . ',0,-1|'),
		),
		array('id_profile')
	);
}

$db_package_log = array();
foreach ($sp_tables as $sp_table_name => $null)
	$db_package_log[] = array('remove_table', $db_prefix . $sp_table_name);

// Update the page table to accept more data
if (empty($modSettings['sp_version']) || $modSettings['sp_version'] < '2.4.1')
{
	$dbtbl = db_table();
	$page_cols = $dbtbl->db_list_columns('{db_prefix}sp_pages', true);

	if (isset($page_cols['body']) && $page_cols['body']['type'] == 'text')
		$dbtbl->db_change_column('{db_prefix}sp_pages', 'body', array('type' => 'mediumtext'));
}

// Update the block table to include the mobile column if needed
$request = $db->query('', 'SHOW FIELDS FROM {db_prefix}sp_blocks');
$fields = array();
while ($row = $db->fetch_assoc($request))
	$fields[] = $row['Field'];
$db->free_result($request);
if (!in_array('mobile_view', $fields))
	$db->query('', 'ALTER TABLE {db_prefix}sp_blocks ADD mobile_view TINYINT NOT NULL DEFAULT "0"');

if (ELK == 'SSI')
	echo 'Database changes were carried out successfully.';