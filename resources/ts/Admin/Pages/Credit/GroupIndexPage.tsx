import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import GroupList from '../../Components/Credit/GroupList';
import VendorActions from '../../Components/Credit/VendorActions';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';
import Preloader from '../../Components/Preloader';
import GroupCollectionInterface from '../../../Interfaces/Collections/Credit/GroupCollectionInterface';

interface GroupIndexPageProps {
	//
}

export default function GroupIndexPage( props: GroupIndexPageProps ) {
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );

	const [ loadingGroups, setLoadingGroups ] = useState<boolean>( true );
	const [ groups, setGroups ] = useState<GroupCollectionInterface>( null );

	useEffect( () => {
		setLoadingGroups( true );
		groupRepository.index().then( ( groupsFound: GroupCollectionInterface ) => {
			setLoadingGroups( false );
			setGroups( groupsFound );
		} );
	 }, [] );

	return (
		<Page title="Group Listing">
			<Panel>
				<PanelBody>
					<PanelRow>
						<VendorActions />
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingGroups }>Registered Groups</Preloader>
				</PanelHeader>
			{
				(
					!loadingGroups &&
					groups
				) &&
				<PanelBody>
					<PanelRow>
						<GroupList groups={ groups } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
