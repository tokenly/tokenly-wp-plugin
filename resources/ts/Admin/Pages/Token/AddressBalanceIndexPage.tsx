import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import Page from '../Page'
import Preloader from '../../Components/Preloader'
import BalanceList from '../../Components/Token/BalanceList'
import AddressRepositoryInterface
	from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface'
import { TYPES } from '../../../Types'

import {
	Button,
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components'
import BalanceCollectionInterface
	from '../../../Interfaces/Collections/Token/BalanceCollectionInterface'
import AddressInterface
	from '../../../Interfaces/Models/Token/AddressInterface'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'

interface BalanceIndexPageProps {
	//
}

export default function BalanceIndexPage( props: BalanceIndexPageProps ) {
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )
	const addressRepository: AddressRepositoryInterface = useInjection(
		TYPES.Repositories.Token.AddressRepositoryInterface
	)
	const urlParams = new URLSearchParams( window.location.search )
	const [ loadingAddress, setLoadingAddress ] = useState<boolean>( false )
	const [ loadingBalance, setLoadingBalance ] = useState<boolean>( false )
	const [ balance, setBalance ] = useState<BalanceCollectionInterface>( null )
	const [ id, setId ] = useState<string>( urlParams.get( 'id' ) )
	const [ address, setAddress ] = useState<AddressInterface>( null )

	useEffect( () => {
		setLoadingBalance( true )
		setLoadingAddress( true )
		addressRepository.balanceIndex( id, {
			with: [ 'balance.meta' ],
		} )
		.then( ( balanceFound: BalanceCollectionInterface ) => {
			setBalance( balanceFound )
			return balanceFound
		} )
		.then( ( balanceFound: BalanceCollectionInterface ) => {
			addressRepository.show( id ).then( (
				addressFound: AddressInterface
			) => {
				setLoadingBalance( false )
				setLoadingAddress( false )
				setAddress( addressFound )
			} )
		} )
	 }, [] )
	
	return (
		<Page title="Token Address Balance Listing">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingBalance }>Balance Listing</Preloader>
				</PanelHeader>
				<PanelBody>
					<PanelRow>
						<b>
							<span>Address: </span>
							<Button
								isLink
								href={
									routes.get(
										'admin',
										'token_address_show',
										{
											address: id
										}
									)
								}
							>
								{ address?.label ?? id }
							</Button>
						</b>
					</PanelRow>
				{ ( !loadingBalance && balance ) &&
					<PanelRow>
						<BalanceList balance={ balance } />
					</PanelRow>
				}
				</PanelBody>
			</Panel>
		</Page>
	)
}
