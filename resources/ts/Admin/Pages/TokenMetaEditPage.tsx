import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TokenMetaRepositoryInterface } from '../../Interfaces/Repositories/TokenMetaRepositoryInterface';
import { TokenMetaData } from '../../Interfaces';
import { TYPES } from '../../Types';

import { 
	TextControl,
	TextareaControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface TokenMetaEditPageData {
	meta: TokenMetaData;
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPageData;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
	meta: TokenMetaData;
	postId: number;
	// extraTemp: string;
	// extraValid: boolean,
}

declare const wp: any;


export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	@resolve( TYPES.TokenMetaRepositoryInterface )
	tokenMetaRepository: TokenMetaRepositoryInterface;

	state: TokenMetaEditPageState = {
		storingSource: false,
		meta: {} as any,
		postId: null,
		// extraTemp: null,
		// extraValid: false,
	}
	
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
		// this.validateJSON = this.validateJSON.bind( this );
		const urlParams = new URLSearchParams(window.location.search);
		const postId = parseInt( urlParams.get( 'post' ) );
		this.state.postId = postId;
		this.state.meta = Object.assign( this.state.meta, this.props.pageData.meta );
		// this.state.extraTemp = JSON.stringify( this.state.meta.extra, null, 2 );
		// this.state.extraValid = this.validateJSON( this.state.extraTemp );
	
	}

	// validateJSON( json: any ) {
	// 	try {
	// 		JSON.parse ( json );
	// 		return true;
	// 	} catch (e) {
	// 		return false;
	// 	}
	// }

	// componentDidMount() {
	// 	const textarea: any = document.querySelector(`textarea[name="extrameta"]`);
	// 	textarea.spellcheck = false;
	// }

	render() {
		return (
			<Fragment>
				<Panel header="Additional token meta">
					<PanelBody>
						<PanelRow>
							<div style={{width: '100%'}}>
								<TextControl
									value={this.state.meta.asset}
									label="Asset"
									help="Is used for pairing meta with an asset"
									onChange={( value: any ) => {
										const state = Object.assign( {}, this.state.meta );
										state.asset = value;
										this.setState( { meta: state } );
									}}
									style={{width: '100%', maxWidth: '500px', marginBottom: '8px'}}
								/>
								{/* <TextareaControl 
									value={ this.state.extraTemp }
									label="Extra"
									help="JSON object"
									name="extrameta"
									rows={ 24 }
									onChange={ ( json: any ) => {
										const valid = this.validateJSON( json );
										if ( valid == true ) {
											const state = Object.assign( {}, this.state.meta );
											state.extra = JSON.parse ( json ) ?? '';
											this.setState( {
												meta: state,
												extraValid: true,
												extraTemp: json,
											} );
										} else {
											this.setState( {
												extraTemp: json,
												extraValid: false,
											} );
										}
									} }
								/>
								<div className="json-status">
									<span>State: </span><span style={ { color: this.state.extraValid ? 'green' : 'red' } }>{ this.state.extraValid ? 'Valid' : 'Invalid' }</span>
								</div> */}
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
				<input type="hidden" name="tokenly_data" value={ JSON.stringify( this.state.meta as any ) } />
			</Fragment>
		);
	}
}
