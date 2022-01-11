import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
	Spinner,
} from '@wordpress/components';

interface ResourceEditActionsProps {
	storing: boolean;
	loading?: boolean;
	onStore: any;
	onCancel: any;
	name: string;
	disableStore?: boolean;
}

interface ResourceEditActionsState {
	//
}

export default class ResourceEditActions extends Component<ResourceEditActionsProps, ResourceEditActionsState> {

	constructor( props: ResourceEditActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify="flex-start" align="center" >
				<Button
					isPrimary
					disabled={ this.props.storing || this.props.disableStore }
					onClick={ this.props.onStore }
				>
					{ this.props.storing ? 'Creating' : `Create ${this.props.name}` }
				</Button>
			{ this.props.storing === true &&
				<Spinner/>
			}
				<Button
					isTertiary
					onClick={ this.props.onCancel }
				>
					Cancel
				</Button>
			</Flex>
		);
	}
}
 

