<?php
if ( !function_exists( 'alpha_sc_get_channels' ) ) {
	function alpha_sc_get_channels() {
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