import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	Flex,
} from '@wordpress/components';

interface SavePanelProps {
	label?: string;
	saving: boolean;
	onClick: any;
}

interface SavePanelState {
	//
}

export class SavePanel extends Component<SavePanelProps, SavePanelState> {

	constructor( props: SavePanelProps ) {
		super( props );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="row"
				justify="flex-start"
			>
				<Button
					isPrimary
					isLarge
					disabled={ this.props.saving }
					onClick={ () => {
						this.props.onClick();
					}}
				>
					{ this.props.label ?? 'Save settings' }
				</Button>
				{ this.props.saving === true &&
					<Spinner/>
				}
			</Flex>
		);
	}
}
 

