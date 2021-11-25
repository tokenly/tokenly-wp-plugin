import * as React from 'react';
import { Component } from 'react';

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface TcaRuleEditorProps {
	//
}

interface TcaRuleEditorState {
	//
}

export default class TcaRuleEditor extends Component<TcaRuleEditorProps, TcaRuleEditorState> {

	constructor( props: TcaRuleEditorProps ) {
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
 

