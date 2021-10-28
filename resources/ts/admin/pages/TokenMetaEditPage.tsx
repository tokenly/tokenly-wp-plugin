import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';

import { 
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface TokenMetaEditPageData {
	//
}

interface TokenMeta {
	asset: string,
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPage;
	
	saving: boolean;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
	tokenMeta: TokenMeta;
}

export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	state: TokenMetaEditPageState = {
		storingSource: false,
		tokenMeta: {
			asset: '',
		}
	}
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
	}

	updateAsset( value: any ) {
		const state = Object.assign( {}, this.state );
		state.tokenMeta.asset = value;
		this.setState( state );
	}

	render() {
		return (
			<Panel header="Additional token meta">
				<PanelBody>
					<PanelRow>
						<div style={{width: '100%'}}>
							<TextControl
								value={this.state.tokenMeta.asset}
								label="Asset"
								onChange={( value: any ) => {
									this.updateAsset( value );
								}}
								style={{width: '100%', maxWidth: '500px', marginBottom: '8px'}}
							/>
							<div style={{opacity: 0.8}}>Is used for pairing meta with an asset</div>
						</div>
					</PanelRow>
				</PanelBody>
			</Panel>
		);
	}
}
