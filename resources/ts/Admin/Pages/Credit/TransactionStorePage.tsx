import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from '../Page';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import VendorServiceInterface from '../../../Interfaces/Services/Application/Credit/VendorServiceInterface';
import TransactionStoreForm from '../../Components/Credit/TransactionStoreForm';
import { TYPES } from '../../Types';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import Preloader from '../../Components/Preloader';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface TransactionStorePageProps {
	//
}

export default function TransactionStorePage( props: TransactionStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	const vendorService: VendorServiceInterface = useInjection( TYPES.Services.Application.Credit.VendorServiceInterface );
	const [ storing, setStoring ] = useState<boolean>( false );
	const [ loadingGroups, setLoadingGroups ] = useState<boolean>( false );
	const [ groups, setGroups ] = useState<any>( null );
	const [ storeData, setStoreData ] = useState<any>( {
		type: 'credit',
		quantity: 0,
	} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-group-index`;
	}

	function onStoreSubmit( event: any ) {
		event.preventDefault();
		setStoring( true );
		switch ( storeData.type ) {
			case 'credit':
				vendorService.credit( storeData ).then( ( result: any ) => {
					setStoring( false );
					goBack();
				} );
				break;
			case 'debit':
				vendorService.debit( storeData ).then( ( result: any ) => {
					setStoring( false );
					goBack();
				} );
				break;
		}
	}

	function onCancel() {
		goBack();
	}

	function onStoreDataChange( newData: any ) {
		setStoreData( newData );
	}

	useEffect( () => {
		setLoadingGroups( true );
		groupRepository.index().then( ( groupsFound: any ) => {
			setLoadingGroups( false );
			setGroups( groupsFound );
		} )
		const newStoreData = Object.assign( {}, storeData );
		const urlParams = new URLSearchParams( window.location.search );
		const group = urlParams.get( 'group' );
		if ( group ) {
			newStoreData.group_uuid = group;
		}
		const type = urlParams.get( 'type' );
		if ( type ) {
			newStoreData.type = type;
		}
		const account = urlParams.get( 'account' );
		if ( account ) {
			newStoreData.account = account;
		}
		setStoreData( newStoreData );
	 }, [] );
	
	return (
		<Page title="Transaction Creator">
			<form onSubmit={ onStoreSubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loadingGroups }>Transaction Form</Preloader>
					</PanelHeader>
				{ ( !loadingGroups && groups ) &&
					<PanelBody>
						<PanelRow>
							<TransactionStoreForm
								storeData={ storeData }
								groups={ groups }
								onChange={ onStoreDataChange }
								loadingGroups={ loadingGroups }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Transaction"
								storing={ storing }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
