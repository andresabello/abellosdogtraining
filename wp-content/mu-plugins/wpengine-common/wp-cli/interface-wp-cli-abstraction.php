<?php
/**
 * Wp_Cli_Abstraction
 *
 * @package wpengine/common-mu-plugin
 */

namespace wpe\plugin;

/**
 * Interface Wp_Cli_Abstraction
 */
interface Wp_Cli_Abstraction {
	/**
	 * WP CLI's log
	 *
	 * Documentation: https://make.wordpress.org/cli/handbook/references/internal-api/wp-cli-log/
	 *
	 * @param string $message The log message.
	 * @return void
	 */
	public function log( $message );

	/**
	 * WP CLI's error
	 *
	 * Documentation: https://make.wordpress.org/cli/handbook/references/internal-api/wp-cli-error/
	 *
	 * @param string $message The error message.
	 * @return void
	 */
	public function error( $message );

	/**
	 * WP CLI's add_hook
	 *
	 * Documentation: https://make.wordpress.org/cli/handbook/references/internal-api/wp-cli-add-hook/
	 *
	 * @param string       $hook_name Name of the action to be hooked.
	 * @param string|array $callback Either a string or an array containing the function/method to be called.
	 * @return void
	 */
	public function add_hook( $hook_name, $callback );

	/**
	 * WP CLI's add_command
	 *
	 * Documentation: https://make.wordpress.org/cli/handbook/references/internal-api/wp-cli-add-command/
	 *
	 * @param string       $cmd_name Name of the command to be created.
	 * @param string|array $callback Either a string or an array containing the function/class to be called.
	 * @return void
	 */
	public function add_command( $cmd_name, $callback );
}
