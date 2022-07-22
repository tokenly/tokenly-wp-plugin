import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import Page from '../Page'
import PromiseRepositoryInterface
	from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface'
import SourceRepositoryInterface
	from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface'
import PromiseList from '../../Components/Token/PromiseList'
import Preloader from '../../Components/Preloader'
import VendorActions from '../../Components/Token/VendorActions'
import { TYPES } from '../../Types'

import { 
	Panel,
	PanelBody,
	PanelHeader,
	PanelRow,
} from '@wordpress/components'
import SourceCollectionInterface
	from '../../../Interfaces/Collections/Token/SourceCollectionInterface'
import PromiseCollectionInterface
	from '../../../Interfaces/Collections/Token/PromiseCollectionInterface'
import PromiseInterface from '../../../Interfaces/Models/Token/PromiseInterface'

interface PromiseIndexPageProps {
	//
}

export default function PromiseIndexPage( props: PromiseIndexPageProps ) {
	const promiseRepository: PromiseRepositoryInterface = useInjection(
		TYPES.Repositories.Token.PromiseRepositoryInterface
	)
	const sourceRepository: SourceRepositoryInterface = useInjection(
		TYPES.Repositories.Token.SourceRepositoryInterface
	)
	
	const [ promises, setPromises ] =
		useState<PromiseCollectionInterface>( null )
	const [ sources, setSources ] = useState<SourceCollectionInterface>( null )
	const [ loadingPromises, setLoadingPromises ] = useState<boolean>( false )
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false )

	useEffect( () => {
		setLoadingPromises( true )
		setLoadingSources( true )
		promiseRepository.index( {
			with: [
				'promise_meta.source_user',
				'promise_meta.destination_user',
				'token_meta',
			],
		} ).then( ( promisesFound: PromiseCollectionInterface ) => {
			setLoadingPromises( false )
			setPromises( promisesFound )
			sourceRepository.index( {
				with: [ 'address' ],
			} ).then( ( sourcesFound: SourceCollectionInterface ) => {
				promisesFound.forEach( (item: PromiseInterface, key: any ) => {
					promisesFound.get( key ).source = sourcesFound.get(
						item.sourceId
					)
				} )
				console.log(promisesFound)
				setLoadingSources( false )
				setPromises( promisesFound )
				setSources( sourcesFound )
			} )
		} )
	}, [] )

	return (
		<Page title="Promise Listing">
			<Panel header="Promise Actions">
				<PanelBody>
					<PanelRow>
						<VendorActions />
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader 
						loading={ ( loadingPromises || loadingSources ) }
					>
						Registered Promises
					</Preloader>
				</PanelHeader>
			{ ( !loadingPromises && promises ) &&
				<PanelBody>
					<PanelRow>
						<PromiseList promises={ promises } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	)
}
