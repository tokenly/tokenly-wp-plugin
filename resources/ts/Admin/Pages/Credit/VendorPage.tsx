import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import GroupList from '../../Components/Credit/GroupList';
import VendorActions from '../../Components/Credit/VendorActions';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';
import Preloader from '../../Components/Preloader';

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
}

export default function VendorPage( props: VendorPageProps ) {
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );

	const [ loadingGroups, setLoadingGroups ] = useState<boolean>( false );
	const [ groups, setGroups ] = useState<any>( null );

	useEffect( () => {
		setLoadingGroups( true );
		groupRepository.index().then( ( groupsFound: any ) => {
			setLoadingGroups( false );
			setGroups( groupsFound );
		} );
	 }, [] );

	return (
		<Page title="Credit Vendor">
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
