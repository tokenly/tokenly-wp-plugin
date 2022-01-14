import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../../Page';
import Preloader from '../../../Components/Preloader';
import BalanceList from '../../../Components/Token/BalanceList';
import UserRepositoryInterface from '../../../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

interface BalanceIndexPageData {
	//
}

interface BalanceIndexPageProps {
	pageData: BalanceIndexPageData;
}

export default function BalanceIndexPage( props: BalanceIndexPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );

	const [ id, setId ] = useState<string>( urlParams.get( 'id' ) );
	const [ loadingUser, setLoadingUser ] = useState<boolean>( false );
	const [ loadingBalance, setLoadingBalance ] = useState<boolean>( false );
	const [ balance, setBalance ] = useState<any>( null );
	const [ user, setUser ] = useState<any>( null );


	useEffect( () => {
		setLoadingBalance( true );
		setLoadingUser( true );
		userRepository.tokenBalanceIndex( id, {
			with: [ 'meta' ],
		} )
		.then( ( balancesFound: any ) => {
			setBalance( balancesFound );
			return balancesFound;
		} )
		.then( ( balancesFound: any ) => {
			userRepository.show( id, {
				with: [ 'oauth_user' ],
			} ).then( ( userFound: any ) => {
				setLoadingBalance( false );
				setLoadingUser( false );
				setUser( userFound );
			} );
		} );
	}, [] );

	return (
		<Page title="User Token Balance Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingBalance }>Balance Listing</Preloader>
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
				{ ( loadingBalance === false || balance ) &&
					<PanelRow>
						<BalanceList balance={ balance } />
					</PanelRow>
				}
				</PanelBody>
			</Panel>
		</Page>
	);
}
