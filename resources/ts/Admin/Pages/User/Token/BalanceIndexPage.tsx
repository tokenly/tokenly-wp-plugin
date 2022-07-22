import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import Page from '../../Page'
import Preloader from '../../../Components/Preloader'
import BalanceList from '../../../Components/Token/BalanceList'
import UserRepositoryInterface
	from '../../../../Interfaces/Repositories/UserRepositoryInterface'
import { TYPES } from '../../../../Types'

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components'
import BalanceCollectionInterface
	from '../../../../Interfaces/Collections/Token/BalanceCollectionInterface'
import UserInterface from '../../../../Interfaces/Models/UserInterface'

interface BalanceIndexPageProps {
	//
}

export default function BalanceIndexPage( props: BalanceIndexPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const dictionary: any = useInjection( TYPES.Variables.dictionary )
	const userRepository: UserRepositoryInterface = useInjection(
		TYPES.Repositories.UserRepositoryInterface
	)

	const urlParams = new URLSearchParams( window.location.search )

	const [ id, setId ] = useState<string>( urlParams.get( 'id' ) )
	const [ loadingUser, setLoadingUser ] = useState<boolean>( false )
	const [ loadingBalance, setLoadingBalance ] = useState<boolean>( false )
	const [ balance, setBalance ] = useState<BalanceCollectionInterface>( null )
	const [ user, setUser ] = useState<UserInterface>( null )

	useEffect( () => {
		setLoadingBalance( true )
		setLoadingUser( true )
		userRepository.tokenBalanceIndex( id, {
			with: [ 'meta' ],
		} )
		.then( ( balancesFound: BalanceCollectionInterface ) => {
			setBalance( balancesFound )
			return balancesFound
		} )
		.then( ( balancesFound: BalanceCollectionInterface ) => {
			userRepository.show( id, {
				with: [ 'oauth_user' ],
			} ).then( ( userFound: UserInterface ) => {
				setLoadingBalance( false )
				setLoadingUser( false )
				setUser( userFound )
			} )
		} )
	}, [] )

	return (
		<Page title={ dictionary.get( 'userTokenBalanceTitle' ) }>
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingBalance }>
						{ dictionary.get( 'userBalanceSectionTitle' ) }
					</Preloader>
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
				{ ( !loadingBalance && balance ) &&
					<PanelRow>
						<BalanceList balance={ balance } username={ user?.name } />
					</PanelRow>
				}
				</PanelBody>
			</Panel>
		</Page>
	)
}
