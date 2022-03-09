import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import WhitelistEditor from '../../Components/Token/WhitelistEditor';
import { WhitelistData, WhitelistItem } from '../../../Interfaces';
import WhitelistRepositoryInterface from '../../../Interfaces/Repositories/Token/WhitelistRepositoryInterface';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { TYPES } from '../../Types';
import eventBus from "../../../EventBus";
import { 
	Panel,
	PanelBody,
	PanelRow,
	ToggleControl,
} from '@wordpress/components';

interface WhitelistEditPageProps {
	whitelist: WhitelistData;
}

declare const window: any;

export default function WhitelistEditPage( props: WhitelistEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const whitelistSettingsRepository: WhitelistRepositoryInterface = useInjection( TYPES.Repositories.Token.WhitelistRepositoryInterface );
	
	const enabled = props.whitelist?.enabled ?? false;
	let items = Object.assign( [], props.whitelist?.items ) as any;
	if ( items && Array.isArray( items ) ) {
		items = items.filter( function ( item: any ) {
			return item != null;
		} );
	} else {
		items = [];
	}
	const [ editData, setEditData ] = useState<any>( {
		enabled: enabled,
		items: items,
	}, );
	const [ saving, setSaving ] = useState<any>( false );
	
	function onSave() {
		setSaving( true );
		whitelistSettingsRepository.update( editData ).then( ( result: any ) => {
			setSaving( false );
			goBack();
		} ).catch( ( error: any ) => {
			console.log( error );
		} );
	}

	function onCancel() {
		goBack();
	}

	function onEnabledFieldChange( value: boolean ) {
		let newState = Object.assign( {}, editData );
		newState.enabled = value;
		setEditData( newState );
	}

	function onWhitelistFieldChange( value: Array<any> ) {
		value = value.filter( function ( item: any ) {
			return item != null;
		} );
		const newState = Object.assign( {}, editData );
		newState.items = value;
		setEditData( newState );
	}

	function goBack() {
		window.location = `${ adminPageUrl }${ namespace }-token-vendor`;
	}

	return (
		<Page title="Whitelist Editor" >
			<Panel header="Whitelist Settings">
				<PanelBody>
					<PanelRow>
						<p style={ { maxWidth: '550px', opacity: 0.8 } }>Whitelist allows to control which assets to filter when working with token assets. Only the specified assets will be displayed and searchable.</p>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label="Use Whitelist"
							checked={ editData.enabled }
							onChange={ onEnabledFieldChange }
						/>
					</PanelRow>
					{ editData.enabled == true &&
						<PanelRow>
							<WhitelistEditor
								onChange={ onWhitelistFieldChange }
								items={ editData?.items }
							/>		
						</PanelRow>
					}
				</PanelBody>					
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<ResourceEditActions
							name="Whitelist"
							saving={ saving }
							onSave={ onSave }
							onCancel={ onCancel }
							noDelete
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
 

