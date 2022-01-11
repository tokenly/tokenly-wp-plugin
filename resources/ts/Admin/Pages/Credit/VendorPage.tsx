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
						<Preloader loading={ this.state.loadingGroups }>Registered groups</Preloader>
					</PanelHeader>
				{
					(
						!this.state.loadingGroups &&
						this.state.groups &&
						typeof this.state.groups === 'object'
					) &&
					<PanelBody>
						<PanelRow>
							<Flex>
								{ Object.keys( this.state.groups ).length > 0
									? 	<GroupList
											groups={ this.state.groups }
										/>
									: 	<div style={ { opacity: 0.5 } }>There are no registered groups</div>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
