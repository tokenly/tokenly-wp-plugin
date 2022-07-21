import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import { WhitelistData, WhitelistItem } from '../../../Interfaces';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { TYPES } from '../../Types';
import Preloader from '../../Components/Preloader';
import { 
	Panel,
	PanelBody,
	PanelRow,
	CheckboxControl,
	Flex,
	PanelHeader,
} from '@wordpress/components';

interface GroupWhitelistEditPageProps {
	whitelist: WhitelistData;
}

declare const window: any;

export default function GroupWhitelistEditPage( props: GroupWhitelistEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	
	const [ editData, setEditData ] = useState<any>( {
		whitelist: props.whitelist,
	} );
	const [ saving, setSaving ] = useState<any>( false );
	const [ loadingGroups, setLoadingGroups ] = useState<any>( true );
	const [ groups, setGroups ] = useState<any>( [] );
	
	function onSave() {
		setSaving( true );
		let params = Object.assign( {}, editData );
		params.whitelist.items = Object.assign( {}, params.whitelist.items );
		groupRepository.whitelistUpdate( params ).then( ( result: any ) => {
			setSaving( false );
			goBack();
		} ).catch( ( error: any ) => {
			console.log( error );
		} );
	}

	useEffect( () => {
		setLoadingGroups( true );
		groupRepository.index( {
			filtered: false,
		} ).then( ( groupsFound: any ) => {
			setLoadingGroups( false );
			setGroups( groupsFound );
		} );
	 }, [] );

	function onCancel() {
		goBack();
	}

	function onWhitelistFieldChange( value: boolean, uuid: string ) {
		let newState = Object.assign( {}, editData );
		newState.whitelist.items[ uuid ] = value;
		setEditData( newState );
	}

	function isGroupChecked( uuid: string ) {
		let checked: boolean = false;
		if ( editData && editData.whitelist.items[ uuid ] ) {
			checked = editData.whitelist.items[ uuid ]
		}
		return checked;
	}

	function goBack() {
		window.location = `${ adminPageUrl }${ namespace }-credit-vendor`;
	}


	const groupItems = Array.from( groups.values() ).map( ( group: any, index: number ) => {
		return (
			<CheckboxControl
				label={ group.name }
				checked={ isGroupChecked( group.uuid ) }
				onChange={ ( value: any ) => {
					onWhitelistFieldChange( value, group.uuid );
				} }
			/>
		);
	} );

	return (
		<Page title="Group Whitelist Editor" >
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingGroups }>Whitelist Setttings</Preloader>
				</PanelHeader>
			{	(
					!loadingGroups &&
					groupItems
				) &&
				<PanelBody>
					<PanelRow>
						<p style={ { maxWidth: '550px', opacity: 0.8 } }>Whitelist allows to control which groups will be available when working with credits.</p>
					</PanelRow>
					<PanelRow>
						<div style={ { width: '100%' } }>
							{ ( Array.isArray( groupItems ) && groupItems.length > 0 )
							?	<Flex
									style={ { width: '100%' } }
									// @ts-ignore
									direction="column"
								>
									{ groupItems }
								</Flex>
							: 	<div style={ { opacity: 0.5 } }>{ `No groups were found.` }</div>
							}
						</div>
					</PanelRow>
				</PanelBody>
			}			
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
 

