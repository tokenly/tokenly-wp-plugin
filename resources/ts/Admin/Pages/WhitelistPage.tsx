import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Whitelist } from '../Components/Whitelist';
import { SavePanel } from '../Components/SavePanel';
import { Component } from 'react';
import { WhitelistData, WhitelistItem } from '../../Interfaces';
import { WhitelistRepositoryInterface } from '../../Interfaces/Repositories/WhitelistRepositoryInterface';
import { TYPES } from '../../Types';
import { 
	Panel,
	PanelBody,
	PanelRow,
	ToggleControl,
} from '@wordpress/components';

interface WhitelistPageData {
	whitelist: WhitelistData;
}

interface WhitelistPageProps {
	pageData: WhitelistPageData; 
}

interface WhitelistPageState {
	whitelistData: WhitelistData;
	saving: boolean;
}

export default class WhitelistPage extends Component<WhitelistPageProps, WhitelistPageState> {
	@resolve( TYPES.WhitelistRepositoryInterface )
	whitelistRepository: WhitelistRepositoryInterface;
	
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
		this.setUseWhitelist = this.setUseWhitelist.bind( this );
		this.state.whitelistData = Object.assign( this.state.whitelistData, this.props.pageData.whitelist );
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
		this.whitelistRepository.update( this.state.whitelistData ).then( result => {
			this.setState( { saving: false } );
		} ).catch( error => {
			console.log( error );
		})
	}

	render() {
		return (
			<Page title={'Token Whitelist 123'} >
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
				{ this.state.whitelistData.use_whitelist == true &&
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
 

