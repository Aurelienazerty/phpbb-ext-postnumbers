<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\acp;

class postnumbers_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_log;

		$user->add_lang('acp/common');
		$this->tpl_name = 'acp_postnumbers';
		$this->page_title = $user->lang('POSTNUMBERS_TITLE');

		add_form_key('acp_postnumbers');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_postnumbers'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action));
			}

			$config->set('kasimi.postnumbers.enabled.viewtopic', $request->variable('postnumbers_enabled_viewtopic', 0));
			$config->set('kasimi.postnumbers.enabled.review_reply', $request->variable('postnumbers_enabled_review_reply', 0));
			$config->set('kasimi.postnumbers.enabled.review_mcp', $request->variable('postnumbers_enabled_review_mcp', 0));
			$config->set('kasimi.postnumbers.skip_nonapproved', $request->variable('postnumbers_skip_nonapproved', 0));
			$config->set('kasimi.postnumbers.display_ids', $request->variable('postnumbers_display_ids', 0));
			$config->set('kasimi.postnumbers.location', $request->variable('postnumbers_location', 0));
			$config->set('kasimi.postnumbers.clipboard', $request->variable('postnumbers_clipboard', 0));
			$config->set('kasimi.postnumbers.bold', $request->variable('postnumbers_bold', 0));

			$user_id = (empty($user->data)) ? ANONYMOUS : $user->data['user_id'];
			$user_ip = (empty($user->ip)) ? '' : $user->ip;
			$phpbb_log->add('admin', $user_id, $user_ip, 'POSTNUMBERS_CONFIG_UPDATED');

			trigger_error($user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'POSTNUMBERS_VERSION'				=> '1.1.1',
			'POSTNUMBERS_ENABLED_VIEWTOPIC'		=> $config['kasimi.postnumbers.enabled.viewtopic'],
			'POSTNUMBERS_ENABLED_REVIEW_REPLY'	=> $config['kasimi.postnumbers.enabled.review_reply'],
			'POSTNUMBERS_ENABLED_REVIEW_MCP'	=> $config['kasimi.postnumbers.enabled.review_mcp'],
			'POSTNUMBERS_SKIP_NONAPPROVED'		=> $config['kasimi.postnumbers.skip_nonapproved'],
			'POSTNUMBERS_DISPLAY_IDS'			=> $config['kasimi.postnumbers.display_ids'],
			'POSTNUMBERS_LOCATION'				=> $config['kasimi.postnumbers.location'],
			'POSTNUMBERS_CLIPBOARD'				=> $config['kasimi.postnumbers.clipboard'],
			'POSTNUMBERS_BOLD'					=> $config['kasimi.postnumbers.bold'],
			'U_ACTION'							=> $this->u_action,
		));
	}
}
