import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import * as dayjs from 'dayjs'
import { PromiseSourceInfo } from '../../Components/Token/PromiseSourceInfo';
import { PromiseParticipants } from '../../Components/Token/PromiseParticipants';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface PromiseShowPageData {
	promise: PromiseData;
	sources: any;
}

interface PromiseShowPageProps {
	pageData: PromiseShowPageData;
}

interface PromiseShowPageState {
	//
}

export default class PromiseShowPage extends Component<PromiseShowPageProps, PromiseShowPageState> {
	state: PromiseShowPageState = {
		//
	}
	constructor( props: PromiseShowPageProps ) {
		super( props );
		this.getProperties = this.getProperties.bind( this );
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
				value: this.props.pageData.promise?.asset,
			},
			{
				label: 'Quantity (Sat)',
				value: this.props.pageData.promise?.quantity?.value_sat,
			},
			{
				label: 'Ref',
				value: this.props.pageData.promise?.ref,
			},
			{
				label: 'Note',
				value: this.props.pageData.promise?.note,
			},
			{
				label: 'Created at',
				value: this.dateFormatted( this.props.pageData.promise?.created_at ),
			},
			{
				label: 'Updated at',
				value: this.dateFormatted( this.props.pageData.promise?.updated_at ),
			},
		]
	}
	
	render() {
		const properties = this.getProperties();
		const listItems = properties.map( ( property ) => {
			return (
				<div>
					<span>{ property.label }: </span>
					<span style={{ opacity: property.value ? 1 : 0.6 }}><strong>{ property.value ? property.value : 'No data' }</strong></span>
				</div>
			);
		} );
		return (
			<Page title={ 'Promise details' }>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-token-vendor'>Back to vendor</a>
				</div>
				<Panel header={ `№ ${this.props.pageData.promise.promise_id}` }>
					<PanelBody>
						<PanelRow>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div>
										<span>Source: </span>
										<a href={`/wp-admin/admin.php?page=tokenly-token-source-show&source=${this.props.pageData.promise?.source_id}`}>
											<strong>{this.props.pageData.promise?.source?.address.label}</strong>
										</a>
									</div>
									<PromiseParticipants promise={ this.props.pageData.promise } />
									{ listItems }
								</div>
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
									href={ `/wp-admin/admin.php?page=tokenly-token-promise-edit&promise=${ this.props.pageData.promise.promise_id }` }
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
