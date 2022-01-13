import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupEditForm from '../../Components/Credit/GroupEditForm';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { TYPES } from '../../../Types';
import Preloader from '../../Components/Preloader';
import GroupLink from '../../Components/Credit/GroupLink';

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

declare const window: any;

interface GroupEditPageData {
	//
}

interface GroupEditPageProps {
	pageData: GroupEditPageData;
}

export default function GroupEditPage( props: GroupEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );
	const [ uuid, setUuid ] = useState<string>( urlParams.get( 'group' ) );
	const [ group, setGroup ] = useState<any>( null );
	const [ saving, setSaving ] = useState<boolean>( false );
	const [ loadingGroup, setLoadingGroup ] = useState<boolean>( false );
	const [ editData, setEditData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-vendor`;
	}

	function onSave() {
		let updateParams = Object.assign( {}, editData );
		let whitelist = updateParams?.app_whitelist.replace( /\s/g, '' );
		if ( whitelist == '' ) {
			updateParams.app_whitelist = [];
		} else {
			updateParams.app_whitelist = whitelist.split(',');
		}
		setSaving( true );
		groupRepository.update( uuid, updateParams ).then( ( result: any ) => {
			setSaving( false );
			goBack();
		});
	}

	function onCancel() {
		goBack();
	}

	function onEditDataChange( newData: any ) {
		setEditData( newData );
	}

	useEffect( () => {
		setLoadingGroup( true );
		groupRepository.show( uuid ).then( ( groupFound: any ) => {
			const editDataNew = {
				name: groupFound.name,
			} as any;
			if ( Array.isArray( groupFound.app_whitelist ) ) {
				editDataNew.app_whitelist = groupFound.app_whitelist.join( ', ' );
			} else {
				editDataNew.app_whitelist = '';
			}
			setLoadingGroup( false );
			setGroup( groupFound );
			setEditData( editDataNew );
		} );
	 }, [] );

	return (
		<Page title="Group Editor">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingGroup }>Group Edit Form</Preloader>
				</PanelHeader>
			{ ( !loadingGroup && group ) &&
				<PanelBody>
					<PanelRow>
						<div>
							<span>Group: </span>
							<GroupLink uuid={ uuid } name={ group.name } />
						</div>
					</PanelRow>
					<PanelRow>
						<GroupEditForm
							onChange={ onEditDataChange }
							loadingGroup={ loadingGroup }
							editData={ editData }
						/>
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<ResourceEditActions
							name="Group"
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
