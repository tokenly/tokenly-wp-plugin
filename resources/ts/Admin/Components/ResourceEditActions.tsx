import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
	Spinner,
} from '@wordpress/components';

interface ResourceEditActionsProps {
	saving: boolean;
	deleting?: boolean;
	onSave: any;
	onDelete?: any;
	onCancel: any;
	name: string;
	noDelete?: boolean;
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
					disabled={ this.props.saving }
					onClick={ this.props.onSave }
				>
					{ this.props.saving ? 'Saving' : `Save ${this.props.name}` }
				</Button>
			{ this.props.saving === true &&
				<Spinner/>
			}
			{ !this.props.noDelete &&
				<Button
					isSecondary
					disabled={ this.props.deleting }
					onClick={ this.props.onDelete }
				>
					{ this.props.deleting ? 'Deleting' : `Delete ${this.props.name}` }
				</Button>
			}
			{ this.props.deleting === true &&
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
 

