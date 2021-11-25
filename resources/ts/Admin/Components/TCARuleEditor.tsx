import * as React from 'react';
import { Component } from 'react';

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface TCARuleEditorProps {
	//
}

interface TCARuleEditorState {
	//
}

export default class TCARuleEditor extends Component<TCARuleEditorProps, TCARuleEditorState> {

	constructor( props: TCARuleEditorProps ) {
		super( props );
	}

	render() {
		return (
			<Panel>
				<PanelBody title="TCA Rule Editor" >
					<PanelRow>
						123
					</PanelRow>
				</PanelBody>
			</Panel>
		);
	}
}
 

