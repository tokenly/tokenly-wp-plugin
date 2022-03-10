import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from '../Page';
import AccountList from '../../Components/Credit/AccountList';
import Preloader from '../../Components/Preloader';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../Types';

import {
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';
import AccountCollectionInterface from '../../../Interfaces/Collections/Credit/AccountCollectionInterface';

interface GroupAccountIndexPageProps {
	//
}

export default function GroupAccountIndexPage( props: GroupAccountIndexPageProps ) {
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );

	const [ accounts, setAccounts ] = useState<AccountCollectionInterface>( null );
	const [ loadingAccounts, setLoadingAccounts ] = useState<any>( false );

	useEffect( () => {
		const urlParams = new URLSearchParams( window.location.search );
		const group = urlParams.get( 'id' );
		const params = {
			group: group,
			with: [ 'user' ],
		}
		setLoadingAccounts( true );
		groupRepository.accountIndex( group, params ).then( ( accountsFound: AccountCollectionInterface ) => {
			setLoadingAccounts( false );
			setAccounts( accountsFound );
		} );
	 }, [] );
	
	return (
		<Page title="Group Account Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingAccounts }>Registered Accounts</Preloader>
				</PanelHeader>
			{
				(
					!loadingAccounts &&
					accounts &&
					Array.isArray( accounts )
				) &&
				<PanelBody>
					<PanelRow>
						<AccountList accounts={ accounts } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
