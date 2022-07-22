import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../../Types'
import AddressRepositoryInterface
	from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface'
import SourceRepositoryInterface
	from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface'
import Page from '../Page'
import Preloader from '../../Components/Preloader'
import AddressInfo from '../../Components/Token/AddressInfo'
import AddressStatus from '../../Components/Token/AddressStatus'
import eventBus from "../../../EventBus"

declare const window: any

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
	Button,
	Flex,
} from '@wordpress/components'
import AddressInterface
	from '../../../Interfaces/Models/Token/AddressInterface'
import SourceCollectionInterface
	from '../../../Interfaces/Collections/Token/SourceCollectionInterface'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'

interface AddressShowPageProps {
	//
}

export default function AddressShowPage( props: AddressShowPageProps ) {
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )
	const addressRepository: AddressRepositoryInterface = useInjection(
		TYPES.Repositories.Token.AddressRepositoryInterface
	)
	const sourceRepository: SourceRepositoryInterface = useInjection(
		TYPES.Repositories.Token.SourceRepositoryInterface
	)
	const urlParams = new URLSearchParams( window.location.search )
	const [ id, setId ] = useState<string>( urlParams.get( 'address' ) )
	const [ address, setAddress ] = useState<any>( null )
	const [ sources, setSources ] = useState<any>( null )
	const [ loading, setLoading ] = useState<boolean>( false )
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false )
	const [ deleting, setDeleting ] = useState<boolean>( false )

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice )
		setLoading( true )
		setLoadingSources( true )
		addressRepository.show( id ).then( (
			addressFound: AddressInterface
		) => {
			setLoading( false )
			setAddress( addressFound )
			return addressFound
		} ).then( ( addressFound: AddressInterface ) => {
			sourceRepository.index().then( (
				result: SourceCollectionInterface
			) => {
				setLoadingSources( false )
				setSources( result )
				addressFound = addressFound.clone()
				addressFound.isSource = ( id in result )
				setAddress( addressFound )
			} )
		} )
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice )
		}
	 }, [] )

	 function onDelete(): void {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'addressDelete',
			title: 'Deleting Address',
			subtitle: 'Are you sure you want to delete the address?',
		} )
	}

	function deleteAddress(): void {
		setDeleting( true )
		addressRepository.destroy( id ).then( ( result: any ) => {
			setDeleting( false )
			history.back()
		} )
	}

	function onConfirmModalChoice( payload: any ): void {
		switch( payload.key ) {
			case 'addressDelete':
				if ( payload.choice == 'accept' ){
					deleteAddress()
				}
				break
		}
	}

	function isSource(): boolean {
		return ( id && sources && id in sources )
	}
	
	return (
		<Page title="Address Display">
			<Panel>
				<PanelHeader>
					<Flex
						justify="flex-start"
					>
						<Preloader loading={ ( loading || loadingSources ) }>
							<Flex justify="flex-start">
								<span
									style={ { flexShrink: 0 } }
								>
									Address Info
								</span>
								{ ( !loading && !loadingSources ) &&
									<AddressStatus address={ address } />
								}
							</Flex>
						</Preloader>
					</Flex>
				</PanelHeader>
			{ ( !loading && address ) &&
				<PanelBody>
					<PanelRow>
						<AddressInfo address={ address } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<Flex justify="flex-start">
							<Button
								isSecondary
								isLarge
								href={
									routes.get(
										'admin',
										'token_address_edit',
										{
											address: id
										}
									)
								}
							>
								Edit Address
							</Button>
							<Button
								isSecondary
								isLarge
								href={
									routes.get(
										'admin',
										'token_address_balance_index',
										{
											address: id
										}
									)
								}
							>
								View Balance
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ ( !sources || !isSource() ) }
								href={
									routes.get(
										'admin',
										'token_source_show',
										{
											source: id
										}
									)
								}
							>
								View Source
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ ( !sources || isSource() ) }
								href={
									routes.get(
										'admin',
										'token_source_store',
										{
											address: id
										}
									)
								}
							>
								Make Source
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ address?.verified ?? true }
								href={
									routes.get(
										'admin',
										'token_address_verify',
										{
											address: id
										}
									)
								}
							>
								Verify Address
							</Button>
							<Button
								isDestructive
								isLarge
								isBusy={ deleting }
								onClick={ onDelete }
							>
								Delete Address
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	)
}
