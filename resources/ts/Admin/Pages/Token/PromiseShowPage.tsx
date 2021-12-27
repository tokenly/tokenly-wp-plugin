import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import * as dayjs from 'dayjs'
import PromiseParticipants from '../../Components/Token/PromiseParticipants';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface PromiseShowPageData {
	promise: PromiseData;
	sources: any;
}

interface PromiseShowPageProps {
	pageData: PromiseShowPageData;
}

interface PromiseShowPageState {
	promise: any;
	promiseId: number;
	loadingPromise: boolean;
}

export default class PromiseShowPage extends Component<PromiseShowPageProps, PromiseShowPageState> {
	@resolve( TYPES.Repositories.Token.PromiseRepositoryInterface )
	promiseRepository: PromiseRepositoryInterface;

	state: PromiseShowPageState = {
		promise: null,
		promiseId: null,
		loadingPromise: false,
	}
	constructor( props: PromiseShowPageProps ) {
		super( props );
		this.getProperties = this.getProperties.bind( this );
		this.isPromiseValid = this.isPromiseValid.bind( this );
		this.getListItems = this.getListItems.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		const id = parseInt( urlParams.get( 'promise' ) );
		this.state.promiseId = id;
	}
	
	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	getProperties() {
		return [
			{
				label: 'Asset',
				value: this.state.promise?.asset,
			},
			{
				label: 'Quantity (Sat)',
				value: this.state.promise?.quantity?.value_sat,
			},
			{
				label: 'Ref',
				value: this.state.promise?.ref,
			},
			{
				label: 'Note',
				value: this.state.promise?.note,
			},
			{
				label: 'Created at',
				value: this.dateFormatted( this.state.promise?.created_at ),
			},
			{
				label: 'Updated at',
				value: this.dateFormatted( this.state.promise?.updated_at ),
			},
		]
	}

	isPromiseValid() {
		return ( this.state.promise && typeof this.state.promise === 'object' );
	}

	componentWillMount() {
		this.setState( { loadingPromise: true } );
		const params = {
			with: [
				'source.address',
				'promise_meta.source_user',
				'promise_meta.destination_user',
			],
		}
		this.promiseRepository.show( this.state.promiseId, params ).then( ( promise: any ) => {
			this.setState( {
				loadingPromise: false,
				promise: promise,
			} );
		} );
	}

	getListItems() {
		const properties = this.getProperties();
		return properties.map( ( property ) => {
			return (
				<div>
					<span>{ property.label }: </span>
					<span style={ { opacity: property.value ? 1 : 0.6 } }><strong>{ property.value ? property.value : 'No data' }</strong></span>
				</div>
			);
		} );
	}
	
	render() {

		return (
			<Page title={ 'Promise details' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
				</div>
				<Panel header={ `№ ${this.state?.promiseId}` }>
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loadingPromise
								?	<Flex justify="flex-start">
										<span>Loading promise ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
										{ this.isPromiseValid()
											?	<Flex style={ { width: '100%', alignItems: 'center' } }>
													<div style={ { flex: 1 } }>
														<div>
															<span>Source: </span>
															<a href={`/wp-admin/admin.php?page=tokenly-token-source-show&source=${this.state.promise?.source_id}`}>
																<strong>{this.state.promise?.source?.address.label}</strong>
															</a>
														</div>
														<PromiseParticipants promise={ this.state.promise } />
														{ this.getListItems() }
													</div>
												</Flex>
											: 	<div style={ { opacity: 0.5 } }>Failed to fetch the promise data.</div>
										}
									</Flex>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-promise-edit&promise=${ this.state.promiseId }` }
								>
									Manage promise
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
