import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import WhitelistEditor from '../../Components/Token/WhitelistEditor';
import { Component } from 'react';
import { WhitelistData, WhitelistItem } from '../../../Interfaces';
import WhitelistSettingsRepositoryInterface from '../../../Interfaces/Repositories/Settings/WhitelistSettingsRepositoryInterface';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { TYPES } from '../../../Types';
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
	editData: WhitelistData;
	saving: boolean;
}

declare const window: any;

export default class WhitelistPage extends Component<WhitelistPageProps, WhitelistPageState> {
	@resolve( TYPES.Repositories.Settings.WhitelistSettingsRepositoryInterface )
	whitelistSettingsRepository: WhitelistSettingsRepositoryInterface;
	@resolve( TYPES.Variables.adminUrl )
	adminUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	
	state: WhitelistPageState = {
		editData: {
			enabled: false,
			items: [
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
		this.onCancel = this.onCancel.bind( this );
		const enabled = this.props.pageData?.whitelist?.enabled ?? false;
		let items = Object.assign( [], this.props.pageData?.whitelist?.items ) as any;
		if ( items && Array.isArray( items ) ) {
			items = items.filter( function ( item: any ) {
				return item != null;
			} );
		} else {
			items = [];
		}
		this.state.editData = {
			enabled: enabled,
			items: items,
		}
		this.onWhitelistFieldChange = this.onWhitelistFieldChange.bind( this );
		this.onEnabledFieldChange = this.onEnabledFieldChange.bind( this );
	}
	
	onSave() {
		this.setState( { saving: true } );
		this.whitelistSettingsRepository.update( this.state.editData ).then( ( result: any ) => {
			this.setState( { saving: false } );
		} ).catch( ( error: any ) => {
			console.log( error );
		})
	}

	onCancel() {
		this.return();
	}

	onEnabledFieldChange( value: boolean ) {
		let newState = Object.assign( {}, this.state );
		newState.editData.enabled = value;
		this.setState( newState );
	}

	onWhitelistFieldChange( value: Array<any> ) {
		value = value.filter( function ( item: any ) {
			return item != null;
		} );
		let newState = Object.assign( {}, this.state.editData );
		newState.items = value;
		this.setState( { editData: newState } );
	}

	return() {
		window.location = `${ this.adminUrl }${ this.namespace }-token-vendor`;
	}

	render() {
		return (
			<Page title={ 'Whitelist editor' } >
				<Panel header="Whitelist settings">
					<PanelBody>
						<PanelRow>
							<p style={ { maxWidth: '550px', opacity: 0.8 } }>Whitelist allows to control which assets to filter when working with token assets. Only the specified assets will be displayed and searchable.</p>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label="Use whitelist"
								checked={ this.state.editData.enabled }
								onChange={ this.onEnabledFieldChange }
							/>
						</PanelRow>
						{ this.state.editData.enabled == true &&
							<PanelRow>
								<WhitelistEditor
									onChange={ this.onWhitelistFieldChange }
									items={ this.state.editData?.items }
								/>		
							</PanelRow>
						}
					</PanelBody>					
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceEditActions
								name="whitelist"
								saving={ this.state.saving }
								onSave={ this.onSave }
								onCancel={ this.onCancel }
								noDelete
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
 

