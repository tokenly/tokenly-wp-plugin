import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import AddressRepositoryInterface
	from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface'
import SourceRepositoryInterface
	from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface'
import UserRepositoryInterface
	from '../../../Interfaces/Repositories/UserRepositoryInterface'
import { TYPES } from '../../Types'
import Page from '../Page'
import AddressList from '../../Components/Token/AddressList'
import Preloader from '../../Components/Preloader'
import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components'
import UserInterface from '../../../Interfaces/Models/UserInterface'
import AddressCollectionInterface
	from '../../../Interfaces/Collections/Token/AddressCollectionInterface'
import SourceCollectionInterface
	from '../../../Interfaces/Collections/Token/SourceCollectionInterface'
import AddressInterface
	from '../../../Interfaces/Models/Token/AddressInterface'

interface AddressIndexPageProps {
	//
}

export default function AddressIndexPage( props: AddressIndexPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const addressRepository: AddressRepositoryInterface = useInjection(
		TYPES.Repositories.Token.AddressRepositoryInterface
	)
	const sourceRepository: SourceRepositoryInterface = useInjection(
		TYPES.Repositories.Token.SourceRepositoryInterface
	)
	const userRepository: UserRepositoryInterface = useInjection(
		TYPES.Repositories.UserRepositoryInterface
	)
	const [ addresses, setAddresses ] =
		useState<AddressCollectionInterface>( null )
	const [ sources, setSources ] = useState<SourceCollectionInterface>( null )
	const [ loadingAddresses, setLoadingAddresses ] = useState<boolean>( false )
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false )

	useEffect( () => {
		setLoadingAddresses( true )
		setLoadingSources( true )
		userRepository.show( 'me', {
			with: [ 'oauth_user' ],
		} ).then( ( user?: UserInterface ) => {
			if ( !user || !user.oauthUser ) {
				return
			}
			addressRepository.index().then( (
				addressesFound: AddressCollectionInterface
			) => {
				setLoadingAddresses( false )
				setAddresses( addressesFound )
				return addressesFound
			} ).then( (
				addressesFound: AddressCollectionInterface
			) => {
				sourceRepository.index().then( ( sourcesFound: SourceCollectionInterface ) => {
					setLoadingSources( false )
					setSources( sourcesFound )
					addressesFound = addressesFound.clone()
					addressesFound.forEach( ( address: AddressInterface ) => {
						address.isSource = ( sourcesFound.has( address.address ) )
					} )
					setAddresses( addressesFound )
				} )
			} )
		} )
	}, [] )
	
	return (
		<Page title="Address Listing">
			<Panel header="Address Actions">
				<PanelBody>
					<PanelRow>
						<Flex style={ { width: '100%' } }>
							<Button
								isPrimary
								href={ `${adminPageUrl}${namespace}-token-address-store` }
							>
								Register Address
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingAddresses }>Registered Addresses</Preloader>
				</PanelHeader>
			{
				(
					!loadingAddresses &&
					addresses &&
					typeof addresses === 'object'
				) &&
				<PanelBody>
					<PanelRow>
						<AddressList addresses={ addresses } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	)
}
