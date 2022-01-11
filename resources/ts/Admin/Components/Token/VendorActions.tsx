import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

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
	@resolve( TYPES.Variables.adminUrl )
	adminUrl: string;
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: VendorActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify="flex-start">
				<Button
					isPrimary
					isLarge
					href={ `${this.adminPageUrl}${this.namespace}-token-promise-store` }
				>
					Make a Promise
				</Button>
				<Button
					isSecondary
					isLarge
					href={ `${this.adminPageUrl}${this.namespace}-token-source-index` }
				>
					Manage Sources
				</Button>
				<Button
					isSecondary
					isLarge
					href={ `${this.adminPageUrl}${this.namespace}-token-whitelist-edit` }
				>
					Manage Whitelist
				</Button>
				<Button
					isSecondary
					isLarge
					href={ `${this.adminUrl}edit.php?post_type=${this.namespace}_token_meta` }
				>
					Manage Meta
				</Button>
			</Flex>
		);
	}
}
