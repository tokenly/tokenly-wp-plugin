import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SavePanelProps {
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
			<Panel>
				<PanelBody>
					<PanelRow className="save-button-container">
						<Button
							isPrimary
							isLarge
							disabled={ this.props.saving }
							onClick={ () => {
								this.props.onClick();
							}}
						>
							Save settings
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
					</PanelRow>
				</PanelBody>
			</Panel>
		);
	}
}
 

