import * as React from 'react'
import { useInjection } from 'inversify-react'
import { useState, useEffect } from 'react'
import Page from '../Page'
import { TYPES } from '../../Types'
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface'
import GroupInfo from '../../Components/Credit/GroupInfo'
import GroupShowActions from '../../Components/Credit/GroupShowActions'
import Preloader from '../../Components/Preloader'

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components'
import GroupInterface from '../../../Interfaces/Models/Credit/GroupInterface'

interface GroupShowPageProps {
	//
}

export default function GroupShowPage( props: GroupShowPageProps ) {
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface )
	
	const urlParams = new URLSearchParams( window.location.search )
	const [ uuid, setUuid ] = useState<string>( urlParams.get( 'id' ) )
	const [ group, setGroup ] = useState<GroupInterface>( null )
	const [ loadingGroup, setLoadingGroup ] = useState<boolean>( null )

	useEffect( () => {
		setLoadingGroup( true )
		groupRepository.show( uuid ).then( ( groupFound: any ) => {
			setLoadingGroup( false )
			setGroup( groupFound )
		} )
	 }, [] )

	return (
		<Page title="Group Details">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingGroup }>Group Info</Preloader>
				</PanelHeader>
			{ ( !loadingGroup && group ) &&
				<PanelBody>
					<PanelRow>
				{ Object.keys( group ).length > 0
					?	<GroupInfo group={ group } verbose />
					: 	<div style={ { opacity: 0.5 } }>Failed to fetch the group data.</div>
				}
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<GroupShowActions group={ uuid } />
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	)
}
