import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import Page from '../Page'
import VendorServiceInterface from '../../../Interfaces/Services/Application/Token/VendorServiceInterface'
import PromiseStoreForm from '../../Components/Token/PromiseStoreForm'
import Preloader from '../../Components/Preloader'
import ResourceStoreActions from '../../Components/ResourceStoreActions'
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface'
import { TYPES } from '../../Types'

declare const window: any

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components'

interface PromiseStorePageProps {
	//
}

export default function PromiseStorePage( props: PromiseStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const vendorService: VendorServiceInterface = useInjection( TYPES.Services.Application.Token.VendorServiceInterface )
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface )
	
	const [ storeData, setStoreData ] = useState<any>( {} )
	const [ sources, setSources ] = useState<any>( null )
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false )
	const [ storing, setStoring ] = useState<boolean>( false )

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-promise-index`
	}

	function onStoreSubmit( event: any ) {
		event.preventDefault()
		setStoring( true )
		vendorService.promise( storeData ).then( ( result: any ) => {
			setStoring( false )
			goBack()
		} )
	}

	function onCancel() {
		goBack()
	}

	function onStoreDataChange( newData: any ) {
		setStoreData( newData )
	}

	useEffect( () => {
		setLoadingSources( true )
		sourceRepository.index( {
			with: [ 'address.balance' ],
		} ).then( ( sourcesFound: any ) => {
			setLoadingSources( false )
			setSources( sourcesFound )
		} )
		.then( () => {
			const newStoreData: any = {
				quantity: 0,
				pseudo: false,
			}
			const urlParams = new URLSearchParams( window.location.search )
			const asset = urlParams.get( 'asset' )
			if ( asset ) {
				newStoreData.asset = asset
			}
			const destination = urlParams.get( 'destination' )
			if ( destination ) {
				newStoreData.destination = destination
			}
			setStoreData( newStoreData )
		} )
	}, [] )
	
	return (
		<Page title="Promise Creator">
			<form onSubmit={ onStoreSubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loadingSources }>Promise Form</Preloader>
					</PanelHeader>
				{ ( !loadingSources && sources ) &&
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onChange={ onStoreDataChange }
								loadingSources={ loadingSources }
								storeData={ storeData }
								sources={ sources }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Promise"
								storing={ storing }
								loading={ ( loadingSources ) }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	)
}
