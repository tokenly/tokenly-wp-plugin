import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Whitelist } from '../components/Whitelist';
import { SavePanel } from '../components/SavePanel';
import { Component } from 'react';
import { WhitelistService, WhitelistItem, WhitelistData } from '../../services/WhitelistService';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Panel,
	PanelBody,
	PanelRow,
	ToggleControl,
} = wp.components;

interface WhitelistPageProps {
	//
}

interface WhitelistPageState {
	whitelistData: WhitelistData;
	saving: boolean;
}

export default class WhitelistPage extends Component<WhitelistPageProps, WhitelistPageState> {
	@resolve
	whitelistService: WhitelistService;
	
	state: WhitelistPageState = {
		whitelistData: {
			use_whitelist: false,
			whitelist: [
				{
					address: '',
					index: '',
				},
			],
		},
		saving: false,
	};
	
	constructor( props: WhitelistPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onWhitelistChange = this.onWhitelistChange.bind( this );
	}
	
	componentDidMount() {
		this.whitelistService.getWhitelist().then( ( whitelistData: WhitelistData ) => {
			this.setState( {
				whitelistData: whitelistData,
			} );
		} );
	}
	
	onWhitelistChange( newWhitelist: Array<WhitelistItem> ) {
		let newState = Object.assign( {}, this.state );
		newState.whitelistData.whitelist = Object.assign( [], newWhitelist );
		newState.whitelistData.whitelist = newState.whitelistData.whitelist.filter( function ( whitelistItem: WhitelistItem ) {
			return whitelistItem != null;
		} );
		this.setState( { ...newState } );
	}
	
	setUseWhitelist( value: boolean ) {
		let newState = Object.assign( {}, this.state );
		newState.whitelistData.use_whitelist = value;
		this.setState( newState );
	}
	
	onSave() {
		this.setState( { saving: true } );
		this.whitelistService.updateWhitelist( this.state.whitelistData ).then( result => {
			this.setState( { saving: false } );
		} ).catch( error => {
			console.log( error );
		})
	}

	render() {
		return (
			<Page title={'Token Whitelist'} >
				<Panel header="Token Whitelist Settings">
					<PanelBody>
						<PanelRow>
							<p>Whitelist allows to control which token assets to display on the Inventory screen.</p>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label="Use whitelist"
								help={
									this.state.whitelistData.use_whitelist
										? 'Whitelist enabled.'
										: 'Whitelist disabled.'
								}
								checked={ this.state.whitelistData.use_whitelist }
								onChange={ ( value: boolean ) => {
									this.setUseWhitelist( value );
								} }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				{ this.state.whitelistData.use_whitelist === true &&
					<Panel header="Token Whitelist Editor">
						<PanelBody>
							<PanelRow>
								<Whitelist onUpdate={ this.onWhitelistChange } whitelist={ this.state.whitelistData.whitelist } />		
							</PanelRow>
						</PanelBody>
					</Panel>
				}
				<SavePanel saving={ this.state.saving } onClick={ this.onSave } />
			</Page>
		);
	}
}
 

