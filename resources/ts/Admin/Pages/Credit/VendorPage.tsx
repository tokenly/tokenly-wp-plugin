import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupList from '../../Components/Credit/GroupList';
import VendorActions from '../../Components/Credit/VendorActions';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components';
import Preloader from '../../Components/Preloader';

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
}

interface VendorPageState {
	loadingGroups: boolean;
	groups: any;
}

export default class VendorPage extends Component<VendorPageProps, VendorPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: VendorPageState = {
		loadingGroups: false,
		groups: {},
	}
	constructor( props: VendorPageProps ) {
		super( props );
	}

	componentWillMount() {
		this.setState( { loadingGroups: true } );
		this.groupRepository.index().then( ( groups ) => {
			this.setState( {
				loadingGroups: false,
				groups: groups,
			} );
		} );
	}
	
	render() {
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
						<Preloader loading={ this.state.loadingGroups }>Registered Groups</Preloader>
					</PanelHeader>
				{
					(
						!this.state.loadingGroups &&
						this.state.groups
					) &&
					<PanelBody>
						<PanelRow>
							<GroupList groups={ this.state.groups } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
