import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from '../../Page';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Credit/BalanceList';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
import GroupRepositoryInterface from '../../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';
import GroupCollectionInterface from '../../../../Interfaces/Collections/Credit/GroupCollectionInterface';
import AccountCollectionInterface from '../../../../Interfaces/Collections/Credit/AccountCollectionInterface';
import UserInterface from '../../../../Interfaces/Models/UserInterface';
import AccountInterface from '../../../../Interfaces/Models/Credit/AccountInterface';

interface BalanceIndexPageProps {
	//
}

export default function BalanceIndexPage( props: BalanceIndexPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );

	const [ id, setId ] = useState<string>( urlParams.get( 'id' ) );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ user, setUser ] = useState<any>( null );
	const [ balance, setBalance ] = useState<any>( null );

	useEffect( () => {
		setLoading( true );
		userRepository.creditBalanceIndex( id ).then( ( balancesFound: AccountCollectionInterface ) => {
			setBalance( balancesFound );
			return balancesFound;
		} )
		.then( ( balancesFound: any ) => {
			groupRepository.index( id ).then( ( groupsFound: GroupCollectionInterface ) => {
				balancesFound = balancesFound.map( ( balanceFound: AccountInterface ) => {
					for ( let i = 0; i < groupsFound.size; ++i ) {
						const groupFound = groupsFound.get( i.toString() );
						if ( balanceFound.groupId === groupFound.uuid ) {
							balanceFound.group = groupFound;
							break;
						}
					}
					return balanceFound;
				} );
				setBalance( balancesFound );
			} );
		} )
		.then( () => {
			userRepository.show( id, {
				with: [ 'oauth_user' ],
			} ).then( ( userFound: UserInterface ) => {
				setLoading( false );
				setUser( userFound );
			} );
		} );
	}, [] );

	return (
		<Page title="User Credit Balance Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loading }>Balance Listing</Preloader>
				</PanelHeader>
				<PanelBody>
					<PanelRow>
						<b>
							<span>User: </span>
							<a href={ `/${namespace}/user/${id}` }>
								{ user?.name ?? id }
							</a>
						</b>
					</PanelRow>
				{ ( !loading && balance ) &&
					<PanelRow>
						<BalanceList balance={ balance } username={ user?.name } />
					</PanelRow>
				}
				</PanelBody>
			</Panel>
		</Page>
	);
}
