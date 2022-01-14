import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import Page from './../Page';
import Preloader from '../../Components/Preloader';
import SourceInfo from '../../Components/Token/SourceInfo';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components';

interface SourceShowPageData {
	//
}

interface SourceShowPageProps {
	pageData: SourceShowPageData;
}

export default function SourceShowPage( props: SourceShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );

	const [ id, setId ] = useState<string>( urlParams.get( 'source' ) );
	const [ source, setSource ] = useState<any>( null );
	const [ loadingSource, setLoadingSource ] = useState<boolean>( false );
	const [ loadingAddress, setLoadingAddress ] = useState<boolean>( false );

	function isSourceValid() {
		return ( source && typeof source === 'object' );
	}

	useEffect( () => {
		setLoadingSource( true );
		setLoadingAddress( true );
		sourceRepository.show( id ).then( ( sourceFound: any ) => {
			setLoadingSource( false );
			setSource( sourceFound );
			return sourceFound;
		} )
		.then( ( sourceFound: any ) => {
			addressRepository.show( sourceFound.address_id ).then( ( addressFound: any ) => {
				sourceFound.address = addressFound;
				setSource( sourceFound );
				setLoadingAddress( false );
			} )
		} )
	}, [] );
	
	return (
		<Page title="Source Display">
			<Panel>
				<PanelHeader>
					<Preloader loading={ ( loadingSource || loadingAddress ) }>Source Info</Preloader>
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
								href={ `${adminPageUrl}${namespace}-token-source-edit&source=${id}` }
							>
								Edit Source
							</Button>
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-token-address-balance-index&id=${id}` }
							>
								View Balance
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
