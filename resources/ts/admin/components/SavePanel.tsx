import * as React from 'react';
import { Component } from 'react';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

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
							{ __( 'Save settings' ) }
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
 

