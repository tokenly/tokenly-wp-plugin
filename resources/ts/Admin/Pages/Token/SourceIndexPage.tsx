import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../Types';
import { SourceItem } from '../../../Interfaces';
import Page from './../Page';
import SourceList from '../../Components/Token/SourceList';
import Preloader from '../../Components/Preloader';
import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface SourceIndexPageProps {
	//
}

export default function SourceIndexPage( props: SourceIndexPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );

	const [ sources, setSources ] = useState<any>( null );
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingSources( true );
		sourceRepository.index( {
			with: [ 'address' ],
		} ).then( ( sourcesFound: any ) => {
			sourcesFound = Object.values( sourcesFound );
			setLoadingSources( false );
			setSources( sourcesFound );
		} );
	}, [] );
	
	return (
		<Page title="Source Listing">
			<Panel header="Source Actions">
				<PanelBody>
					<PanelRow>
						<Flex style={ { width: '100%' } }>
							<Button
								isPrimary
								href={ `${adminPageUrl}${namespace}-token-source-store` }
							>
								Register Source
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingSources }>Registered Sources</Preloader>
				</PanelHeader>
			{
			(
				!loadingSources &&
				sources &&
				typeof sources === 'object'
			) &&
				<PanelBody>
					<PanelRow>
						<SourceList sources={ sources } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
