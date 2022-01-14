import * as React from 'react';
import { useInjection } from 'inversify-react';
import { useState, useEffect } from 'react';
import Page from './../Page';
import { TYPES } from '../../../Types';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupInfo from '../../Components/Credit/GroupInfo';
import Preloader from '../../Components/Preloader';

import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface GroupShowPageData {
	//
}

interface GroupShowPageProps {
	pageData: GroupShowPageData;
}

export default function GroupShowPage( props: GroupShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );
	const [ uuid, setUuid ] = useState<string>( urlParams.get( 'group' ) );
	const [ group, setGroup ] = useState<any>( null );
	const [ loadingGroup, setLoadingGroup ] = useState<boolean>( null );

	useEffect( () => {
		setLoadingGroup( true );
		groupRepository.show( uuid ).then( ( groupFound: any ) => {
			setLoadingGroup( false );
			setGroup( groupFound );
		} );
	 }, [] );

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
						<Flex justify="flex-start">
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-credit-group-edit&group=${ group?.uuid }` }
							>
								Manage Group
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
