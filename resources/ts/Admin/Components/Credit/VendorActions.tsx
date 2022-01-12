import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';
import { 
	Button,
	Flex,
} from '@wordpress/components';

interface VendorActionsProps {
	//
}

interface VendorActionsState {
	//
}

export default class VendorActions extends Component<VendorActionsProps, VendorActionsState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: VendorActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex
				justify="flex-start"
				style={ { width: '100%' } }
			>
				<Button
					isPrimary
					href={ `${this.adminPageUrl}${this.namespace}-credit-transaction-store` }
				>
					Make Transaction
				</Button>
				<Button
					isPrimary
					href={ `${this.adminPageUrl}${this.namespace}-credit-group-store` }
				>
					Register Group
				</Button>
			</Flex>
		);
	}
}
 

