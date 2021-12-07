import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';
import * as dayjs from 'dayjs'
import { PromiseSourceInfo } from '../Components/PromiseSourceInfo';
import { PromiseParticipants } from '../Components/PromiseParticipants';

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
	}
	
	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}
	
	render() {
		return (
			<Page title={ 'Promise details' }>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenly-vendor'>Back to vendor</a>
				</div>
				<Panel header={ `№ ${this.props.pageData.promise.promise_id}` }>
					<PanelBody>
						<PanelRow>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<PromiseSourceInfo promise={ this.props.pageData.promise } sources={ this.props.pageData.sources } />
									<PromiseParticipants promise={ this.props.pageData.promise } />
									<div><span>Asset: </span><strong>{ this.props.pageData.promise.asset }</strong></div>
									<div><span>Quantity: </span><strong>{ this.props.pageData.promise.quantity }</strong></div>
									<div><span>Ref: </span><span><strong>{this.props.pageData.promise.ref}</strong></span></div>
									<div><span>Note: </span><span><strong>{this.props.pageData.promise.note}</strong></span></div>
									<div><span>Created at: </span><span><strong>{this.dateFormatted( this.props.pageData.promise.created_at ) }</strong></span></div>
									<div><span>Updated at: </span><span><strong>{this.dateFormatted( this.props.pageData.promise.updated_at ) }</strong></span></div>
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
									href={ `/wp-admin/admin.php?page=tokenly-promise-edit&promise=${ this.props.pageData.promise.promise_id }` }
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
