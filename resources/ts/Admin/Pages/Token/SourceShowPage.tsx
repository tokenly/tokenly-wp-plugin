import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import AddressRepositoryInterface
	from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface'
import SourceRepositoryInterface
	from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface'
import Page from '../Page'
import Preloader from '../../Components/Preloader'
import SourceInfo from '../../Components/Token/SourceInfo'
import eventBus from "../../../EventBus"

import {
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components'
import SourceInterface from '../../../Interfaces/Models/Token/SourceInterface'
import AddressInterface from '../../../Interfaces/Models/Token/AddressInterface'

declare const window: any

interface SourceShowPageProps {
	//
}

export default function SourceShowPage( props: SourceShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const addressRepository: AddressRepositoryInterface = useInjection(
		TYPES.Repositories.Token.AddressRepositoryInterface
	)
	const sourceRepository: SourceRepositoryInterface = useInjection(
		TYPES.Repositories.Token.SourceRepositoryInterface
	)
	const urlParams = new URLSearchParams( window.location.search )
	const [ id, setId ] = useState<string>( urlParams.get( 'source' ) )
	const [ source, setSource ] = useState<any>( null )
	const [ loadingSource, setLoadingSource ] = useState<boolean>( false )
	const [ loadingAddress, setLoadingAddress ] = useState<boolean>( false )
	const [ deleting, setDeleting ] = useState<boolean>( false )

	function isDisabled(): boolean {
		return ( !source?.address )
	}

	function isSourceValid(): boolean {
		return ( source && typeof source === 'object' )
	}

	function onDelete(): void {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'sourceDelete',
			title: 'Deleting Source',
			subtitle: 'Are you sure you want to delete the source?',
		} )
	}

	function onConfirmModalChoice( payload: any ): void {
		switch( payload.key ) {
			case 'sourceDelete':
				if ( payload.choice == 'accept' ){
					deleteSource()
				}
				break
		}
	}

	function deleteSource(): void {
		setDeleting( true )
		sourceRepository.destroy( id ).then( ( result: any ) => {
			setDeleting( false )
			history.back()
		} )
	}

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice )
		setLoadingSource( true )
		setLoadingAddress( true )
		sourceRepository.show( id ).then( ( sourceFound: SourceInterface ) => {
			setLoadingSource( false )
			setSource( sourceFound )
			return sourceFound
		} )
		.then( ( sourceFound: SourceInterface ) => {
			addressRepository.show( id ).then( (
				addressFound: AddressInterface
			) => {
				sourceFound.address = addressFound
				setSource( sourceFound )
				setLoadingAddress( false )
			} )
		} )
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice )
		}
	}, [] )

	const editSourceUrl =
		`${adminPageUrl}${namespace}-token-source-edit&source=${id}`
	const viewBalanceUrl =
		`${adminPageUrl}${namespace}-token-address-balance-index&id=${id}`
	return (
		<Page title="Source Display">
			<Panel>
				<PanelHeader>
					<Preloader
						loading={ ( loadingSource || loadingAddress ) }
					>
						Source Info
					</Preloader>
				</PanelHeader>
			{ ( !loadingSource && source ) &&
				<PanelBody>
					<PanelRow>
						<Flex>
							{ isSourceValid()
								?	<SourceInfo source={ source } />
								: 	<div style={ { opacity: 0.5 } }>Failed to fetch the source data.</div>
							}
						</Flex>
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
								href={ editSourceUrl }
							>
								Edit Source
							</Button>
							<Button
								disabled={ isDisabled() }
								isSecondary
								isLarge
								href={ viewBalanceUrl }
							>
								View Balance
							</Button>
							<Button
								isDestructive
								isLarge
								isBusy={ deleting }
								onClick={ onDelete }
							>
								Delete Source
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	)
}
