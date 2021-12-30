import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface VendorActionsProps {
	//
}

interface VendorActionsState {
	//
}

export default class VendorActions extends Component<VendorActionsProps, VendorActionsState> {

	constructor( props: VendorActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify="flex-start">
				<Button
					isPrimary
					isLarge
					href='/wp-admin/admin.php?page=tokenly-token-promise-store'
				>
					Make a promise
				</Button>
				<Button
					isSecondary
					isLarge
					href='/wp-admin/admin.php?page=tokenly-token-source-index'
				>
					Manage sources
				</Button>
			</Flex>
		);
	}
}
 

