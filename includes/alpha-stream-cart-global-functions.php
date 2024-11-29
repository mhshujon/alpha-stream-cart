<?php
if ( !function_exists( 'alpha_sc_get_channels' ) ) {
	/**
	 * Retrieve the list of available channels.
	 *
	 * @return array List of channels with their titles and pro status.
	 *
	 * @since 1.0.0
	 */
	function alpha_sc_get_channels(): array {
		return [
			[
				'title'  => 'Facebook',
				'is_pro' => false
			],
			[
				'title'  => 'YouTube',
				'is_pro' => true
			],
			[
				'title'  => 'Twitch',
				'is_pro' => true
			]
		];
	}
}