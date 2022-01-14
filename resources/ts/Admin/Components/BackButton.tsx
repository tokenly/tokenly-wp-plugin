import * as React from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

export default function BackButton() {
	function onClick() {
		history.back();
	}

	return (
		<Flex justify="flex-start">
			<Button isTertiary icon="arrow-left-alt" onClick={ onClick }>Go Back</Button>
		</Flex>
	);
}
 

