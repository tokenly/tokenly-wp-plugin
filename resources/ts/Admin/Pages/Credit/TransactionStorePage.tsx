import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import TransactionRepositoryInterface from '../../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import TransactionStoreForm from '../../Components/Credit/TransactionStoreForm';
import { TYPES } from '../../../Types';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import Preloader from '../../Components/Preloader';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';


interface TransactionStorePageData {
	//
}

interface TransactionStorePageProps {
	pageData: TransactionStorePageData;
	saving: boolean;
}

export default function TransactionStorePage( props: TransactionStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	const transactionRepository: TransactionRepositoryInterface = useInjection( TYPES.Repositories.Credit.TransactionRepositoryInterface );
	
	const [ storing, setStoring ] = useState<boolean>( false );
	const [ loadingGroups, setLoadingGroups ] = useState<boolean>( false );
	const [ groups, setGroups ] = useState<any>( null );
	const [ storeData, setStoreData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-vendor`;
	}

	function isStoreDisabled() {
		return false;
	}

	function onStore() {
		setStoring( true );
		transactionRepository.store( storeData ).then( ( result: any ) => {
			setStoring( false );
			goBack();
		});
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
			const storeData = {
				quantity: 0,
				pseudo: false,
				type: 'credit',
			}
			setLoadingGroups( false );
			setGroups( groupsFound );
			setStoreData( storeData );
		} )
		.then( () => {
			const urlParams = new URLSearchParams( window.location.search );
			const group = urlParams.get( 'group' );
			if ( group ) {
				const newStoreData = Object.assign( {}, storeData );
				newStoreData.group_uuid = group;
				setStoreData( newStoreData );
			}
			const type = urlParams.get( 'type' );
			if ( type ) {
				const newStoreData = Object.assign( {}, storeData );
				newStoreData.type = type;
				setStoreData( newStoreData );
			}
		} );
	 }, [] );
	
	return (
		<Page title="Transaction Creator">
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
							onStore={ onStore }
							onCancel={ onCancel }
							disableStore={ isStoreDisabled() }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
